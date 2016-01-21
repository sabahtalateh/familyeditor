var cy = cytoscape({

    container: document.getElementById('cy'),

    style: [
        {
            selector: 'node',
            style: {
                'background-color': '#337ab7',
                'label': 'data(name)'
            }
        },
        {
            selector: 'edge',
            style: {
                'width': 3,
                'line-color': '#ccc',
                'target-arrow-color': '#ccc',
                'target-arrow-shape': 'triangle',
                'label': 'data(name)'
            }
        }
    ],
    layout: {
        name: 'grid'
    }
});

var graphFromTreeBuilder = {
    currentElementId: 0,
    genTree: {},
    genTreeWithCouples: [],
    objectsPerLevels: {},

    countObjectsPerLevels: function () {
        this.rearrangeSiblings();
        this.countPerLevels();

        this.objectsPerLevels = sortObject(this.objectsPerLevels);
    },

    countPerLevels: function () {
        for (index in this.genTree) {
            var node = this.genTree[index];
            var level = parseInt(node.level);
            var propertyName = level.toString();

            if (this.objectsPerLevels.hasOwnProperty(propertyName)) {
                this.objectsPerLevels[propertyName].push(node);
            } else {
                this.objectsPerLevels[propertyName] = [];
                this.objectsPerLevels[propertyName].push(node);
            }
        }
    },

    rearrangeSiblings: function () {
        for (index in this.genTree) {
            var node = this.genTree[index];
            if (node.parent_id_1 != null && node.parent_id_2 != null) {
                var parent_1_level = this.findNodeById(node.parent_id_1).level;
                var parent_2_level = this.findNodeById(node.parent_id_2).level;

                if (parent_1_level != parent_2_level) {
                    var maxLevel = Math.max(parent_1_level, parent_2_level);
                    this.findNodeById(node.parent_id_1).level = maxLevel;
                    this.findNodeById(node.parent_id_2).level = maxLevel;
                }
            }
        }
    },

    findNodeById: function (id) {
        var found = true;
        var result;
        for (index in this.genTree) {
            var el = this.genTree[index];
            if (el.id == id) {
                found = true;
                result = el;
            }
        }
        if (found) {
            return result;
        } else {
            return null;
        }
    },

    getNodeSibling: function (node) {
        for (index in this.genTree) {
            var el = this.genTree[index];
            if (node.id == el.parent_id_1) {

                console.log(el.parent_id_2 + ' sibling for ' + node.id);
            }

            if (node.id == el.parent_id_2) {
                console.log(el.parent_id_1 + ' sibling for ' + node.id);
            }

        }
    },

    appendNodes: function (cy) {
        var level = 0;
        for (var i = 0; i < Object.keys(this.objectsPerLevels).length; i++) {
            //
            var objects = this.objectsPerLevels[i];
            var elementsOnLevel = this.objectsPerLevels[i].length;
            var xn = 0.0;
            var dy = 100;
            var dx = 100;

            xn = -((elementsOnLevel - 1) / 2) * dx;

            for (var j in objects) {
                var node = objects[j];
                cy.add([
                    {
                        group: "nodes",
                        data: {
                            id: node.id,
                            name: node.first_name
                        },
                        position: {x: xn, y: level * dy}
                    }
                ]);
                xn += dx;
            }
            level++;
        }
        cy.getElementById(this.currentElementId).style('background-color', '#BD3324')
    },

    appendChildEdges: function (cy) {
        var parenChildEdgeStyle = {
            'width': 4,
            'line-color': '#d9534f',
            'target-arrow-color': '#d9534f',
            'target-arrow-shape': 'triangle'
        };

        for (index in this.genTree) {
            var node = this.genTree[index];
            var edgeId;
            if (node.parent_id_1 !== null && node.parent_id_1 !== node.parent_id_2) {
                edgeId = node.parent_id_1.toString() + node.id.toString();
                cy.add({
                    group: "edges",
                    data: {id: edgeId, source: node.parent_id_1, target: node.id},
                    style: parenChildEdgeStyle
                });
            }

            if (node.parent_id_2 !== null && node.parent_id_1 !== node.parent_id_2) {
                edgeId = node.parent_id_2.toString() + node.id.toString();
                cy.add({
                    group: "edges",
                    data: {id: edgeId, source: node.parent_id_2, target: node.id},
                    style: parenChildEdgeStyle
                });
            }

            if (node.parent_id_1 === node.parent_id_2 && node.parent_id_1 !== null && node.parent_id_2 !== null) {
                edgeId = node.parent_id_1.toString() + node.id.toString();
                cy.add({
                    group: "edges",
                    data: {id: edgeId, source: node.parent_id_1, target: node.id},
                    style: parenChildEdgeStyle
                });
            }
        }
    },

    appendCouplesEdges: function (cy) {
        var coupleEdgeStyle = {
            'width': 4,
            'line-color': '#337ab7',
            'target-arrow-shape': 'none',
            'label': 'data(name)'
        };
        for (index in this.genTree) {
            var node = this.genTree[index];
            var edgeId;
            if (node.parent_id_1 !== null && node.parent_id_2 !== null) {
                if (node.parent_id_1 !== node.parent_id_2) {
                    edgeId = node.parent_id_1.toString() + node.parent_id_2.toString();
                    if (cy.getElementById(edgeId).length === 0) {
                        cy.add({
                            group: "edges",
                            data: {
                                id: edgeId,
                                name: "+",
                                source: node.parent_id_2,
                                target: node.parent_id_1
                            },
                            style: coupleEdgeStyle
                        });
                    }
                }
            }
        }
    }
};
if (typeof (currentElementId) !== "undefined") {
    graphFromTreeBuilder['currentElementId'] = currentElementId;
}
graphFromTreeBuilder['genTree'] = gentree;
graphFromTreeBuilder.countObjectsPerLevels();
graphFromTreeBuilder.appendNodes(cy);
graphFromTreeBuilder.appendChildEdges(cy);
graphFromTreeBuilder.appendCouplesEdges(cy);
cy.fit();


function sortObject(o) {
    var sorted = {},
        key, a = [];

    for (key in o) {
        if (o.hasOwnProperty(key)) {
            a.push(key);
        }
    }

    a.sort();

    for (key = 0; key < a.length; key++) {
        sorted[a[key]] = o[a[key]];
    }
    return sorted;
}
