export function pathParamHelper(path_list) {


    var first_ucword = path_list[0].charAt(0).toUpperCase() + path_list[0].slice(1);
    var second_ucword = path_list[1].charAt(0).toUpperCase() + path_list[1].slice(1);
    var side_selector = '';
    var path_side_selector = '';
    var dotted_side_selector = '';
    var underscore_side_selector = '';

    if (!window.is_frontend) {
        //side_selector = 'user';
        //path_side_selector = side_selector + '/';
        //dotted_side_selector = side_selector + '.';
        //underscore_side_selector = side_selector + '_';
    }
    
    var side_selector_ucword = side_selector.charAt(0).toUpperCase() + side_selector.slice(1);

    var reqular_const = {
        'path_arr': path_list,
        'path': path_side_selector + path_list[0] + '/' + path_list[1],
        'dotted': dotted_side_selector + path_list[0] + '.' + path_list[1],
        'underscore': underscore_side_selector + path_list[0] + '_' + path_list[1],
        'connected': side_selector_ucword + first_ucword + second_ucword,
        'graphql_name': '',
    };

    if(window.is_frontend){
        var reqular_graphql_name = (second_ucword == first_ucword) ? path_list[0] + 's' : path_list[0] + second_ucword + 's';

        reqular_const.graphql_name = 'user' + reqular_graphql_name.charAt(0).toUpperCase() + reqular_graphql_name.slice(1);
    } else{
        reqular_const.graphql_name = (second_ucword == first_ucword) ? path_list[0] + 's' : path_list[0] + second_ucword + 's';

    }


    console.log(reqular_const.graphql_name);
    console.log('');
    console.log('');
    console.log('');
    console.log('');



    return reqular_const;
}

export function formInputProcessorHelper(field, t) {

    var select_name = '';
    var input_field = {};

    if (field.type) {

        var input_fields_arr = [
            "",
            "text", "password", "reset", "color", "date",
            "email", "month", "number", "range", "search",
            "tel", "time", "url", "week"
        ];

        if (input_fields_arr.indexOf(field.type) > 0) {
            input_field['type'] = "input";
            input_field['inputType'] = field.type;
        } else {
            input_field['type'] = field.type;
        }
    }

    if (field.name) {

        select_name = field.name + '_list';
        var tmp_label = field.name.replace('_id', '').replace('_', ' ').replace(/\w\S*/g, function (word) {
            return word.charAt(0).toUpperCase() + word.substr(1).toLowerCase();
        });

        input_field['id'] = field.name.toLowerCase();
        input_field['label'] = tmp_label;
        input_field['model'] = field.name.toLowerCase();
        input_field['placeholder'] = "Your " + tmp_label;
    }


    if (field.type === 'selectrecord') {

        input_field['type'] = 'select';

        input_field['values'] = [];


    } else if (field.type === 'yesno') {

        input_field['type'] = 'switch';
        input_field['textOn'] = "Yes";
        input_field['textOff'] = "No";
        input_field['valueOn'] = 1;
        input_field['valueOff'] = 0;

    } else if (field.type === 'selectyesno') {

        input_field['type'] = 'select';

        input_field['values'] = [{
            id: 1,
            name: 'Yes'
        }, {
            id: 0,
            name: 'No'
        }];
    }

    if (field.id) {
        input_field['id'] = field.id;
    }

    if (field.label) {
        input_field['label'] = field.label;
    }

    if (field.model) {
        input_field['model'] = field.model;
    }

    if (field.placeholder) {
        input_field['placeholder'] = field.placeholder;
    }

    if (field.styleClasses) {
        input_field['styleClasses'] = field.styleClasses;
    }

    if (field.featured) {
        input_field['featured'] = field.featured;
    }

    if (field.required) {
        input_field['required'] = field.required;
    }

    if (field.readonly) {
        input_field['readonly'] = field.readonly;
    }

    if (field.disabled) {
        input_field['disabled'] = field.disabled;
    }

    if (field.values) {
        input_field['values'] = field.values;
    }

    if (field.visible) {

        var function_str = '(function (model) { \
            return model && ' + field.visible + ';\
        })';

        input_field['visible'] = eval(function_str);

    }

    return input_field;
}


export function saveRecordHelper(this_var, path_param, schema_fields, return_url) {

    const t = this_var;
    var input_fields_arr = [
        "",
        "id", "created_at", "createdBy{id,name,email,username}", "updated_at", "updatedBy{id,name,email,username}",
    ];


    var save_str = "";
    save_str = "mutation{  create" + path_param.connected + "( ";

    if (t.model.id) {
        save_str =
            "mutation{  update" + path_param.connected + "(  id:" + t.model.id + ", ";
    }

    schema_fields.forEach(function (single_field) {

        var is_needed = (input_fields_arr.indexOf(single_field.name) > 0) ? false : true;

        if (single_field.name && is_needed) {

            var field_name = single_field.name;
            var field_prefix = single_field.prefix;
            var field_suffix = single_field.suffix;

            var field_value = t.model[field_name];

            /*
            if (!field_prefix.length) {
                if (field_value === null || field_value === undefined) {
                    field_value = 0;
                }
            }
            */

            if (t.model[field_name] && t.model[field_name] !== null) {

                save_str = save_str + field_name + ':' + field_prefix + field_value + field_suffix + ',';
            }

        }
    });

    save_str = save_str + ' ){ id, } }';

    window.axios
        .post("/graphql", {
            query: save_str
        })
        .then(response => {
            var tmpitem;
            if (t.model.id) {
                tmpitem = response.data.data['update' + path_param.connected];
            } else {
                tmpitem = response.data.data['create' + path_param.connected];
            }

            if (!t.no_redirect) {
                if (return_url) {
                    t.$router.push({
                        path: return_url
                    });
                } else {
                    t.$router.push({
                        name: path_param.dotted + ".edit",
                        params: {
                            id: tmpitem.id
                        }
                    });
                }

            }

        });
}


export function fetchOptionsHelper(this_var, listName, path_param, field_list) {

    const t = this_var;
    t.show_delete_btn = false;
    t.loading_message = "Fetching Data. Please Wait...";

    var query_str = "query { " + path_param.graphql_name + "( first:100 ) { ";

    query_str = query_str + "edges {cursor node  { ";

    field_list.forEach(function (single_field) {
        query_str = query_str + single_field + ',';
    });

    query_str = query_str + "  } } } }";

    window.axios.post("/graphql", {
        query: query_str
    }).then(response => {

        if (response.data.data) {

            var returned_data = [];
            var tmpitems_arr = JSON.parse(JSON.stringify(response.data.data[path_param.graphql_name].edges));

            tmpitems_arr.forEach(function (tmptmpitem) {

                var string_name = '';
                var tmpitem = tmptmpitem.node;

                field_list.forEach(function (single_field) {
                    if (single_field != 'id') {
                        string_name = string_name + tmpitem[single_field] + ': ';
                    }
                });

                returned_data.push({
                    id: tmpitem['id'],
                    name: string_name
                });
            });


            var fiel=this_var.schema.fields.find(field => field.model === listName);
            //console.log(fiel);
            fiel.values=returned_data;


            //t.select_list[listName] = returned_data;
            //t.$set(t.select_list, listName, returned_data);

        } else {

            var message = '';

            response.data.errors.forEach(function (error) {
                message = message + error.message;
            });
        }
    });


}

export function fetchRecordHelper(this_var, path_param, schema_fields, query_str, prefix, return_to) {

    const t = this_var;
    t.show_delete_btn = false;
    t.loading_message = "Fetching Data. Please Wait...";

    const tmp_return_to = return_to || false;
    const tmp_prefix = prefix || 'find_';
    const tmp_query_str = query_str || "id: " + t.id;


    if (!t.id && query_str === '') {
        return;
    }

    if (query_str === '') {

        query_str = "query {" + tmp_prefix + path_param.underscore + "( " + tmp_query_str + ") {";

        schema_fields.forEach(function (single_field) {
            query_str = query_str + single_field + ',';
        });

        query_str = query_str + " }  }";
    }





    window.axios
        .post("/graphql", {
            query: query_str
        })
        .then(response => {

            if (response.data.data) {
                var tmpitem = response.data.data[tmp_prefix + path_param.underscore];

                if (!tmp_return_to) {
                    schema_fields.forEach(function (single_field) {

                        if (single_field.includes("{")) {

                            var str_split = single_field.split('{')[0];
                            str_split = str_split.trim();

                            if (tmpitem[str_split]) {
                                t.model[str_split] = tmpitem[str_split].id;
                            }

                        } else {
                            t.model[single_field] = tmpitem[single_field];
                        }

                    });
                } else {
                    t[tmp_return_to] = tmpitem;
                }
            } else {

                var message = '';

                response.data.errors.forEach(function (error) {
                    message = message + error.message;
                });
            }

        });
}

export function fetchRecordsHelper(this_var, path_param, query_fields, field_list, target_var, return_raw) {

    const t = this_var;
    t.show_delete_btn = false;
    t.loading_message = "Fetching Data. Please Wait...";

    const tmp_return_raw = return_raw || false;

    var query_str = "query { " + path_param.graphql_name + "(";

    if (t.pagination) {
        query_str = query_str + "first:" + t.pagination.limit + ",";
        query_str = query_str + 'orderBy:"-id",';
    }

    if (Array.isArray(query_fields)) {
        if (!tmp_return_raw) {
            query_fields.forEach(function (single_field) {

                var field_name = single_field.name;
                var field_prefix = single_field.prefix;
                var field_suffix = single_field.suffix;

                if (field_prefix == '"') {
                    if (t.model[field_name].length) {
                        query_str = query_str + ' ' + field_name + ':' + field_prefix + t.model[field_name] + field_suffix + ",";
                    }
                } else {
                    if (t.model[field_name]) {
                        query_str = query_str + ' ' + field_name + ':' + t.model[field_name] + ",";
                    }
                }

            });
        } else {
            query_fields.forEach(function (single_field) {
                query_str = query_str + single_field;
            });
        }
    } else {
        query_str = query_str + query_fields;
    }

    if (!query_str.includes('skip:')) {
        //query_str = query_str + "skip:10";
    }

    query_str = query_str + ") { ";

    query_str = query_str + "edges {cursor node { ";

    field_list.forEach(function (single_field) {
        query_str = query_str + single_field + ',';
    });

    query_str = query_str + "  }}  ";

    if (t.pagination) {
        query_str = query_str + " pageInfo { hasNextPage, hasPreviousPage, startCursor,endCursor }";
    }

    query_str = query_str + "  } \
    }";

    console.log(query_str)


  

    window.axios
        .post("/graphql", {
            query: query_str
        })
        .then(response => {
            if (response.data.data) {

                var tmppagination = "";
                var tmpitems = [];
                var res_tmpitems = response.data.data[path_param.graphql_name].edges;

                if (t.pagination) {
                    tmppagination = response.data.data[path_param.graphql_name].pageInfo;
                }

                if (!tmp_return_raw) {


                    var semi_tmpitems = JSON.parse(JSON.stringify(res_tmpitems));

                    semi_tmpitems.forEach((newitem) => {

                        var node_data = newitem.node;

                        for (var prop in node_data) {
                            if (Object.prototype.hasOwnProperty.call(node_data, prop)) {
                                if(typeof node_data[prop]=== 'string' && node_data[prop].charAt(0) === "{"){
                                    try {
                                        node_data[prop] = JSON.parse(node_data[prop])
                                    } catch (e) {
                                        // is not a valid JSON string
                                    }
                                }
                            }
                        }

                        tmpitems.push(node_data);
                    });
    

                    t.items = JSON.parse(JSON.stringify(tmpitems));

                    if (t.items.length < 1) {
                        t.show_delete_btn = false;
                        t.loading_message = "No Data Available.";
                    } else {
                        if (t.pagination) {
                            t.pagination.totalItems = tmppagination.total;
                            t.pagination.pages = tmppagination.lastPage;
                            t.pagination.page = tmppagination.currentPage;
                        }

                        t.show_delete_btn = true;

                        t.items.forEach(i => {
                                t.$set(t.expanded, i.id, false);
                        });

                    }

                    t.postProcessing(t, field_list);

                } else {
                    t.$set(t, target_var, JSON.parse(JSON.stringify(tmpitems)));
                }
            } else {

                var message = '';

                response.data.errors.forEach(function (error) {
                    message = message + error.message;
                });
            }
        });

}

export function deleteRecordHelper(this_var, path_param, return_url) {

    const t = this_var;

    var selected_items = JSON.parse(JSON.stringify(t.table.selected));

    var index;
    for (index = selected_items.length - 1; index >= 0; --index) {
        var selected_item = selected_items[index];

        window.axios
            .post("/graphql", {
                query: 'mutation {  \
          delete' + path_param.connected + '(id: "' +
                    selected_item.id +
                    '"){ \
            id, \
          }  \
        } '
            })
            .then(response => {
                if (response.data.data) {

                    var tmpitem = response.data.data['delete' + path_param.connected];

                    if (return_url) {
                        t.$router.push({
                            path: return_url
                        });
                    } else {
                        t.$router.push({
                            name: path_param.dotted
                        });
                    }


                } else {

                    var message = '';

                    response.data.errors.forEach(function (error) {
                        message = message + error.message;
                    });
                }
            });
    }
}