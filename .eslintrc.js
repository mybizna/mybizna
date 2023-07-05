module.exports = {
    "root": true,
    "env": {
        "node": true,
        'vue/setup-compiler-macros': true
    },
    "extends": [
        "plugin:vue/vue3-essential",
        "eslint:recommended"
    ],
    "parser": "vue-eslint-parser",
    "parserOptions": {
        "ecmaVersion": 2020,
        "sourceType": "module",
    },
    "plugins": [
        "vue",
    ],
    rules: {
        'vue/multi-word-component-names': 0,
        "no-unused-vars": "off"
    }
}
