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

let input = 'form-input rounded border py-2 px-3 focus:border-sky-500 hover:border-sky-500 text-sm text-grey-800 w-full ';
let text = input + 'h-10 ';
let textarea = input + 'h-50 ';


export default defineConfig({
    theme: vueform,
    locales: { en },
    locale: 'en',
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
            container: 'form-col pr-4 form-py-input-border w-3/12 font-medium text-sm text-gray-700 ',
        },
        ElementLayout: {
            container: 'form-col w-full mb-3 ',
            outerWrapper: 'form-row flex flex-wrap form-mb-gutter ',
            innerContainer: 'flex-1 w-9/12',
            innerWrapperBefore: 'form-col w-full ',
            innerWrapper: 'form-col w-full ',
            innerWrapperAfter: 'form-col w-full ',
        },
        SelectElement: {
            container: '',
            label: '',
            wrapper:'w-full ',
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
        },       
        TextElement: {
            container: '',
            label: '',
            wrapper:'w-full ',
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
        },
        TextareaElement: {
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
        },
    },
    addClass: {
        // Add a custom class to the outermost DOM element of an input field
        input: {
            class: 'my-custom-input-class',
        },
        // Add more class customizations as needed
    },
})
