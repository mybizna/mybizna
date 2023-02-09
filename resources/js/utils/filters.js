import accounting from "accounting";

import fetchComponent from "@/utils/fetchComponent";

const currencyOptions = {
    symbol: "$",
    decimal: ".",
    thousand: ",",
    format: "",
};

const dateFormat = "d/m/Y";

export default {
    __(value, type) {
        return value;
    },
    currencyUSD(value) {
        return "$" + value;
    },
    toCurrency(value) {
        if (typeof value !== "number") {
            return value;
        }
        var formatter = new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "USD",
            minimumFractionDigits: 4,
        });
        return formatter.format(value);
    },
    uppercase(val) {
        if (typeof val === "string") {
            return val.toUpperCase();
        }
        return val;
    },
    money(val) {
        if (typeof val === "number") {
            return `${val.toFixed(2)}`;
        }
    },
    formatAmount(val, prefix = false) {
        if (val < 0) {
            return prefix
                ? `Cr. ${this.moneyFormat(Math.abs(val))}`
                : `${this.moneyFormat(Math.abs(val))}`;
        }

        return prefix
            ? `Dr. ${this.moneyFormat(val)}`
            : `${this.moneyFormat(Math.abs(val))}`;
    },

    formatDBAmount(val, prefix = false) {
        if (val < 0) {
            return `(-) ${this.moneyFormat(Math.abs(val))}`;
        }

        return this.moneyFormat(val);
    },

    showAlert(type, message) {
        this.$swal({
            position: "center",
            type: type,
            title: message,
            showConfirmButton: false,
            timer: 1500,
        });
    },

    getFileName(path) {
        // eslint-disable-next-line no-useless-escape
        return path.replace(/^.*[\\\/]/, "");
    },

    decodeHtml(str) {
        const regex = /^[A-Za-z0-9 ]+$/;

        if (regex.test(str)) {
            return str;
        }

        const txt = document.createElement("textarea");
        txt.innerHTML = str;

        return txt.value;
    },

    moneyFormat(number) {
        return accounting.formatMoney(number, currencyOptions);
    },

    moneyFormatwithDrCr(value) {
        var DrCr = null;

        if (value.indexOf("Dr") > 0) {
            DrCr = "Dr ";
        } else if (value.indexOf("Dr") === -1) {
            DrCr = "Cr ";
        }

        const money = accounting.formatMoney(value, currencyOptions);

        return DrCr + money;
    },

    noFulfillLines(lines, selected) {
        let nofillLines = false;

        for (const item of lines) {
            if (!Object.prototype.hasOwnProperty.call(item, selected)) {
                nofillLines = true;
            } else {
                nofillLines = false;
                break;
            }
        }

        return nofillLines;
    },

    formatDate(d) {
        if (!d) {
            return "";
        }

        var date = new Date(d),
            month = date.getMonth() + 1,
            day = date.getDate(),
            year = date.getFullYear();

        if (month.toString().length < 2) {
            month = "0" + month;
        }

        if (day.toString().length < 2) {
            day = "0" + day;
        }

        switch (dateFormat) {
            case "d/m/Y": // -- 31/12/2020
                return [day, month, year].join("/");

            case "m/d/Y": // -- 12/31/2020
                return [month, day, year].join("/");

            case "m-d-Y": // -- 12-31-2020
                return [month, day, year].join("-");

            case "d-m-Y": // -- 31-12-2020
                return [day, month, year].join("-");

            case "Y-m-d": // -- 2020-12-31
                return [year, month, day].join("-");

            case "d.m.Y": // -- 31.12.2020
                return [day, month, year].join(".");

            default:
                return date.toDateString().replace(/^\S+\s/, "");
        }
    },

    fetchComponent(comp_path) {
        if (Array.isArray(comp_path)) {
            comp_path =
                //"assets/" +
                comp_path[0] + "/admin/" + comp_path[1] + "/" + comp_path[2];
        }

        return fetchComponent(comp_path);
    },

    formatNumber(n) {
        var ending = ["k", "m", "b", "t"];

        var n_str = n.toString();

        if (n_str.length < 4) {
            return n;
        } else {
            //return n_str[0] + ending[Math.floor((n_str.length - 1) / 3) - 1];
            return `${n_str[0]}${n_str[1] != "0" ? `.${n_str[1]}` : ""}${ending[Math.floor((n_str.length - 1) / 3) - 1]
                }`;
        }
    },

    pathParamHelper(path_list) {
        var first_ucword =
            path_list[0].charAt(0).toUpperCase() + path_list[0].slice(1);
        var second_ucword =
            path_list[1].charAt(0).toUpperCase() + path_list[1].slice(1);
        var side_selector = "";
        var path_side_selector = "";
        var dotted_side_selector = "";
        var underscore_side_selector = "";

        var side_selector_ucword =
            side_selector.charAt(0).toUpperCase() + side_selector.slice(1);

        var reqular_const = {
            path_arr: path_list,
            path: path_side_selector + path_list[0] + "/" + path_list[1],
            dotted: dotted_side_selector + path_list[0] + "." + path_list[1],
            underscore:
                underscore_side_selector + path_list[0] + "_" + path_list[1],
            connected: side_selector_ucword + first_ucword + second_ucword,
        };

        if (window.is_backend) {
            reqular_const.path =
                path_side_selector + path_list[0] + "/admin/" + path_list[1];
            reqular_const.dotted =
                dotted_side_selector + path_list[0] + ".admin." + path_list[1];
        }

        return reqular_const;
    },

    formInputProcessorHelper(field, t) {
        var select_name = "";
        var input_field = {};

        if (field.type) {
            var input_fields_arr = [
                "",
                "text",
                "password",
                "reset",
                "color",
                "date",
                "email",
                "month",
                "number",
                "range",
                "search",
                "tel",
                "time",
                "url",
                "week",
            ];

            if (input_fields_arr.indexOf(field.type) > 0) {
                input_field["type"] = "input";
                input_field["inputType"] = field.type;
            } else {
                input_field["type"] = field.type;
            }
        }

        if (field.name) {
            select_name = field.name + "_list";
            var tmp_label = field.name
                .replace("_id", "")
                .replace("_", " ")
                .replace(/\w\S*/g, function (word) {
                    return (
                        word.charAt(0).toUpperCase() +
                        word.substr(1).toLowerCase()
                    );
                });

            input_field["id"] = field.name.toLowerCase();
            input_field["label"] = tmp_label;
            input_field["model"] = field.name.toLowerCase();
            input_field["placeholder"] = "Your " + tmp_label;
        }

        if (field.type === "selectrecord") {
            input_field["type"] = "select";

            input_field["values"] = [];
        } else if (field.type === "yesno") {
            input_field["type"] = "switch";
            input_field["textOn"] = "Yes";
            input_field["textOff"] = "No";
            input_field["valueOn"] = 1;
            input_field["valueOff"] = 0;
        } else if (field.type === "selectyesno") {
            input_field["type"] = "select";

            input_field["values"] = [
                {
                    id: 1,
                    name: "Yes",
                },
                {
                    id: 0,
                    name: "No",
                },
            ];
        }

        if (field.id) {
            input_field["id"] = field.id;
        }

        if (field.label) {
            input_field["label"] = field.label;
        }

        if (field.model) {
            input_field["model"] = field.model;
        }

        if (field.placeholder) {
            input_field["placeholder"] = field.placeholder;
        }

        if (field.styleClasses) {
            input_field["styleClasses"] = field.styleClasses;
        }

        if (field.featured) {
            input_field["featured"] = field.featured;
        }

        if (field.required) {
            input_field["required"] = field.required;
        }

        if (field.readonly) {
            input_field["readonly"] = field.readonly;
        }

        if (field.disabled) {
            input_field["disabled"] = field.disabled;
        }

        if (field.values) {
            input_field["values"] = field.values;
        }

        if (field.visible) {
            var function_str =
                "(function (model) { \
                return model && " +
                field.visible +
                ";\
            })";

            input_field["visible"] = eval(function_str);
        }

        return input_field;
    },

    saveRecordHelper(this_var, path_param, schema_fields, return_url) {
        const t = this_var;

        window.axios.post(path_param.path, t.model).then((response) => {
            var tmpitem = response.data;

            if (Object.prototype.hasOwnProperty.call(tmpitem, "record")) {
                t.record = tmpitem.record;

                t.$notify({
                    title: 'Saving Action',
                    text: 'Record Saved Successfully',
                    type: 'error',
                    speed: 1000,
                    duration: 6000
                });                
            }

        });
    },

    fetchOptionsHelper(this_var, listName, path_param, field_list) {
        const t = this_var;
        t.show_delete_btn = false;
        t.loading_message = "Fetching Data. Please Wait...";

        window.axios
            .post(path_param.path, {
                field_list: field_list,
            })
            .then((response) => {
                if (response.data) {
                    var returned_data = [];

                    response.data.forEach(function (tmpitem) {
                        var string_name = "";

                        field_list.forEach(function (single_field) {
                            if (single_field != "id") {
                                string_name =
                                    string_name + tmpitem[single_field] + ": ";
                            }
                        });

                        returned_data.push({
                            id: tmpitem["id"],
                            name: string_name,
                        });
                    });

                    var fiel = this_var.schema.fields.find(
                        (field) => field.model === listName
                    );
                    fiel.values = returned_data;

                    //t.select_list[listName] = returned_data;
                    //t.$set(t.select_list, listName, returned_data);
                }
            });
    },

    fetchRecordHelper(
        this_var,
        path_param,
        schema_fields,
        query_str,
        prefix,
        return_to
    ) {
        const t = this_var;
        t.show_delete_btn = false;
        t.loading_message = "Fetching Data. Please Wait...";

        const tmp_return_to = return_to || false;

        if (!t.id && query_str === "") {
            return;
        }

        window.axios.get(path_param.path + "/" + t.id).then((response) => {
            if (response.data) {
                var tmpitem = response.data.record;

                if (!tmp_return_to) {

                    Object.keys(t.model).forEach(function (key, index) {
                        if (Object.prototype.hasOwnProperty.call(tmpitem, key)) {
                            t.model[key] = tmpitem[key];
                        }
                    });
                } else {
                    t[tmp_return_to] = tmpitem;
                }
            }
        });
    },

    fetchRecordsHelper(this_var, path_param, search_fields, table_fields) {
        const t = this_var;
        t.show_delete_btn = false;
        t.loading_message = "Fetching Data. Please Wait...";

        var data = {
            s: {},
            f: [],
            limit: t.pagination.limit,
            offset:
                t.pagination.page == 1
                    ? 0
                    : t.pagination.page * t.pagination.limit,
        };

        table_fields.forEach(function (table_field) {
            data["f"].push(table_field.name);
            if (Object.prototype.hasOwnProperty.call(table_field, "foreign")) {
                table_field.foreign.forEach(function (table_field_name) {
                    data["f"].push(table_field_name);
                });
            }
        });

        search_fields.forEach(function (query_field) {
            if (t.model[query_field.name] && t.model[query_field.name] !== "") {
                data["s"][query_field.name] = {
                    str: t.model[query_field.name],
                };

                if (query_field.ope !== "") {
                    data["s"][query_field.name] = {
                        ope: t.opeList[query_field.name],
                    };
                }
            }
        });

        window.axios
            .get(path_param.path, {
                params: data,
            })
            .then((response) => {
                if (response.data) {
                    t.items = response.data.records;

                    if (t.items.length < 1) {
                        t.show_delete_btn = false;
                        t.loading_message = "No Data Available.";
                    } else {
                        if (t.pagination) {
                            t.pagination.pages =
                                t.pagination.limit >= response.data.total
                                    ? 1
                                    : Math.floor(
                                        response.data.total /
                                        t.pagination.limit
                                    );
                            t.pagination.total = response.data.total;
                        }

                        t.show_delete_btn = true;
                    }

                    //t.postProcessing(t, search_fields);
                }
            });
    },

    async deleteRecordHelper(this_var, path_param, ids) {
        const t = this_var;
        var results = [];

        for (let i = 0; i < ids.length; i++) {
            const id = ids[i];

            await window.axios.delete(path_param.path + "/" + id).then((response) => {
                t.$notify({
                    title: 'Deleting Action',
                    text: response.data.message,
                    type: 'error',
                    speed: 1000,
                    duration: 6000
                });
                results.push({ id: id, result: response.data });
            });

            console.log('deleteRecordHelper');
            console.log(results);

        }

        return results;
    },


    toUnicodeVariant(str, variant, flags) {
        const offsets = {
            m: [0x1d670, 0x1d7f6],
            b: [0x1d400, 0x1d7ce],
            i: [0x1d434, 0x00030],
            bi: [0x1d468, 0x00030],
            c: [0x1d49c, 0x00030],
            bc: [0x1d4d0, 0x00030],
            g: [0x1d504, 0x00030],
            d: [0x1d538, 0x1d7d8],
            bg: [0x1d56c, 0x00030],
            s: [0x1d5a0, 0x1d7e2],
            bs: [0x1d5d4, 0x1d7ec],
            is: [0x1d608, 0x00030],
            bis: [0x1d63c, 0x00030],
            o: [0x24B6, 0x2460],
            p: [0x249C, 0x2474],
            w: [0xff21, 0xff10],
            u: [0x2090, 0xff10]
        }

        const variantOffsets = {
            'monospace': 'm',
            'bold': 'b',
            'italic': 'i',
            'bold italic': 'bi',
            'script': 'c',
            'bold script': 'bc',
            'gothic': 'g',
            'gothic bold': 'bg',
            'doublestruck': 'd',
            'sans': 's',
            'bold sans': 'bs',
            'italic sans': 'is',
            'bold italic sans': 'bis',
            'parenthesis': 'p',
            'circled': 'o',
            'fullwidth': 'w'
        }

        // special characters (absolute values)
        var special = {
            m: {
                ' ': 0x2000,
                '-': 0x2013
            },
            i: {
                'h': 0x210e
            },
            g: {
                'C': 0x212d,
                'H': 0x210c,
                'I': 0x2111,
                'R': 0x211c,
                'Z': 0x2128
            },
            o: {
                '0': 0x24EA,
                '1': 0x2460,
                '2': 0x2461,
                '3': 0x2462,
                '4': 0x2463,
                '5': 0x2464,
                '6': 0x2465,
                '7': 0x2466,
                '8': 0x2467,
                '9': 0x2468,
            },
            p: {},
            w: {}
        }
        //support for parenthesized latin letters small cases 
        for (var i = 97; i <= 122; i++) {
            special.p[String.fromCharCode(i)] = 0x249C + (i - 97)
        }
        //support for full width latin letters small cases 
        for (var l = 97; l <= 122; l++) {
            special.w[String.fromCharCode(l)] = 0xff41 + (l - 97)
        }

        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        const numbers = '0123456789';

        var getType = function (variant) {
            if (variantOffsets[variant]) return variantOffsets[variant]
            if (offsets[variant]) return variant;
            return 'm'; //monospace as default
        }
        var getFlag = function (flag, flags) {
            if (!flags) return false
            return flags.split(',').indexOf(flag) > -1
        }

        var type = getType(variant);
        var underline = getFlag('underline', flags);
        var strike = getFlag('strike', flags);
        var result = '';

        for (var k of str) {
            let index
            let c = k
            if (special[type] && special[type][c]) c = String.fromCodePoint(special[type][c])
            if (type && (index = chars.indexOf(c)) > -1) {
                result += String.fromCodePoint(index + offsets[type][0])
            } else if (type && (index = numbers.indexOf(c)) > -1) {
                result += String.fromCodePoint(index + offsets[type][1])
            } else {
                result += c
            }
            if (underline) result += '\u0332' // add combining underline
            if (strike) result += '\u0336' // add combining strike
        }
        return result
    }
};
