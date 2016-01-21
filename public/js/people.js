new Vue({
    el: '#create_children_form',

    data: {
        person: {
            father: '',
            mother: '',
            child: ''
        },
        possible: {
            fathers: [],
            mothers: [],
            children: []
        },
        personToAdd: {
            father: '',
            mother: '',
            child: ''
        }
    },

    computed: {
        errors: function () {
            for (var key in this.person) {
                if (!this.person[key]) return true;
            }
            return false;
        }
    },

    ready: function () {
//                this.fetchPersons();
    },

    methods: {
        fetchPersons: function (query, gender) {
            if (query !== '') {
                var request = '/' + query;
                if (typeof(gender) !== "undefined") {
                    request += '/' + gender;
                }
                this.$http.get('/api/persons' + request, function (persons) {
                    if (typeof(gender) !== "undefined") {
                        if (gender === 1) {
                            this.possible.fathers = persons;
                        }
                        if (gender === 0) {
                            this.possible.mothers = persons;
                        }
                    } else {
                        this.possible.children = persons;
                    }
                });
            }
        },
        setToForm: function (e) {
            var role = e.target.getAttribute('data-role');
            var id = e.target.getAttribute('data-id');
            this.person[role] = e.target.innerHTML;
            this.personToAdd[role] = id;
        }
    }
});