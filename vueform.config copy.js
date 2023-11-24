import en from '@vueform/vueform/locales/en'
import tailwind from '@vueform/vueform/themes/tailwind'

let input = 'form-input rounded border py-2 px-3 focus:border-sky-500 hover:border-sky-500 text-grey-800 h-8 w-full';

export default {
    theme: tailwind,
    locales: { en },
    locale: 'en',
    
    addClasses: {
        ElementDescription: {
            container: 'added-class',
        },
        TextElement: {
            container: 'added-class',

        }
    },
    overrideClasses: {
        VueForm: {
            ComponentName: {
                classname: ['class-value-1', 'class-value-2']
            }
        },

        TextElement: {
            inputContainer: 'w-full flex',
            input: input,
            input_enabled: 'focus:form-ring',
            input_disabled: 'form-bg-disabled form-text-disabled',
            input_sm: 'form-p-input-sm form-rounded-sm form-text-sm',
            input_md: 'form-p-input form-rounded',
            input_lg: 'form-p-input-lg form-rounded-lg form-text-lg with-floating:form-p-input-floating-lg',
            $input: (classes, { isDisabled, Size }) => ([
                classes.input,
                classes[`input_${Size}`],
                isDisabled ? classes.input_disabled : classes.input_enabled
            ]),
        }
    },
    addClass: {
        // Add a custom class to the outermost DOM element of an input field
        input: {
            class: 'my-custom-input-class',
        },
        // Add more class customizations as needed
    },
}


