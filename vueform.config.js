import en from '@vueform/vueform/locales/en'
import vueform from '@vueform/vueform/themes/vueform'
import { defineConfig } from '@vueform/vueform'

import DropzoneElement from '@/vueform/DropzoneElement.vue'
import FaceElement from '@/vueform/FaceElement.vue'
import MediaElement from '@/vueform/MediaElement.vue'
import MonthpickerElement from '@/vueform/MonthpickerElement.vue'
import RecordpickerElement from '@/vueform/RecordpickerElement.vue'
import RecordselectElement from '@/vueform/RecordselectElement.vue'
import WeekpickerElement from '@/vueform/WeekpickerElement.vue'
import YearpickerElement from '@/vueform/YearpickerElement.vue'


// You might place these anywhere else in your project
import '@vueform/vueform/themes/vueform/css/index.min.css';

let input = 'form-input rounded border py-2 px-3 focus:border-sky-500 hover:border-sky-500 text-sm text-grey-800 w-full max-w-96 ';
let text = input + 'h-8 ';
let textarea = input + 'h-50 ';

let text_setting = {
    container: '',
    label: '',
    wrapper: 'w-full ',
    inputContainer: 'w-full flex ',
    inputContainer_default: 'border-black ',
    inputContainer_focused: 'border-red-500 ',
    inputContainer_md: '',
    input: text,
    input_enabled: 'focus:form-ring ',
    input_disabled: 'form-bg-disabled form-text-disabled ',
    input_sm: 'form-p-input-sm form-rounded-sm form-text-sm ',
    input_md: 'form-p-input form-rounded ',
    input_lg: 'form-p-input-lg form-rounded-lg form-text-lg with-floating:form-p-input-floating-lg ',
    $input: (classes, { isDisabled, Size }) => ([
        classes.input,
        classes[`input_${Size}`],
        isDisabled ? classes.input_disabled : classes.input_enabled
    ]),
}

let select_setting = {
    container: '',
    label: '',
    wrapper: 'w-full ',
    inputContainer: 'w-full flex ',
    inputContainer_default: 'border-black ',
    inputContainer_focused: 'border-red-500 ',
    inputContainer_md: '',
    input: text,
    input_enabled: 'focus:form-ring ',
    input_disabled: 'form-bg-disabled form-text-disabled ',
    input_sm: 'form-p-input-sm form-rounded-sm form-text-sm ',
    input_md: 'form-p-input form-rounded ',
    input_lg: 'form-p-input-lg form-rounded-lg form-text-lg with-floating:form-p-input-floating-lg ',
    $input: (classes, { isDisabled, Size }) => ([
        classes.input,
        classes[`input_${Size}`],
        isDisabled ? classes.input_disabled : classes.input_enabled
    ]),
}

let textarea_setting = {
    container: '',
    label: '',
    inputContainer: 'w-full flex ',
    inputContainer_default: 'border-black ',
    inputContainer_focused: 'border-red-500 ',
    inputContainer_md: '',
    input: textarea,
    input_enabled: 'focus:form-ring ',
    input_disabled: 'form-bg-disabled form-text-disabled ',
    input_sm: 'form-p-input-sm form-rounded-sm form-text-sm ',
    input_md: 'form-p-input form-rounded ',
    input_lg: 'form-p-input-lg form-rounded-lg form-text-lg with-floating:form-p-input-floating-lg ',
    $input: (classes, { isDisabled, Size }) => ([
        classes.input,
        classes[`input_${Size}`],
        isDisabled ? classes.input_disabled : classes.input_enabled
    ]),
}


export default defineConfig({
    theme: vueform,
    locales: { en },
    locale: 'en',
    endpoints: {
        unique: async (value, name, params, el$, form$) => {
            console.log(name);
            console.log(params);

            const res = await window.axios.post(params[0], {
                value,
                name,
                params,
            })

            return res.data.error // should be `true` or `false`
        },
        exists: async (value, name, params, el$, form$) => {
            const res = await window.axios.post(params[0], {
                value,
                name,
                params,
            })

            return res.data.error // should be `true` or `false`
        }
    },
    elements: [
        DropzoneElement,
        FaceElement,
        MediaElement,
        MonthpickerElement,
        RecordpickerElement,
        RecordselectElement,
        WeekpickerElement,
        YearpickerElement,
    ],
    overrideClasses: {
        ElementDescription: {
            container: 'text-xs italic text-gray-600 ',
        },
        ElementLabel: {
            container: 'form-col pr-4 form-py-input-border w-full md:w-3/12 lg:w-4/12 font-medium text-sm text-gray-700 pt-1 ',
        },
        ElementLayout: {
            container: 'form-col w-full mb-3 ',
            outerWrapper: 'form-row flex flex-wrap form-mb-gutter ',
            innerContainer: 'flex-1 w-full w-9/12 lg:w-8/12 ',
            innerWrapperBefore: 'form-col w-full ',
            innerWrapper: 'form-col w-full ',
            innerWrapperAfter: 'form-col w-full ',
        },
        SelectElement: select_setting,
        MultiselectElement: select_setting,
        TagsElement: text_setting,
        TextElement: text_setting,
        EditorElement:textarea_setting,
        TextareaElement:textarea_setting,
    },
    addClass: {
        // Add a custom class to the outermost DOM element of an input field
        input: {
            class: 'my-custom-input-class',
        },
        // Add more class customizations as needed
    },
})
