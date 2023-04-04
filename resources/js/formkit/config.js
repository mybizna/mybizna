import {
    createInput
} from '@formkit/vue';
import DatePicker from "@/formkit/inputs/DatePicker";
import DateRangePicker from "@/formkit/inputs/DateRangePicker";
import DateTimePicker from "@/formkit/inputs/DateTimePicker";
import Dropzone from "@/formkit/inputs/Dropzone";
import Editor from "@/formkit/inputs/Editor";
import Face from "@/formkit/inputs/Face";
import Media from "@/formkit/inputs/Media";
import MonthPicker from "@/formkit/inputs/MonthPicker";
import OneTimePassword from "@/formkit/inputs/OneTimePassword";
import YearPicker from "@/formkit/inputs/YearPicker";
import RecordPicker from "@/formkit/inputs/RecordPicker";
import RecordSelect from "@/formkit/inputs/RecordSelect";
import Switch from "@/formkit/inputs/Switch";
import TimePicker from "@/formkit/inputs/TimePicker";
import WeekPicker from "@/formkit/inputs/WeekPicker";

import {
    generateClasses
} from '@formkit/themes';


//input: 'form-input rounded border py-2 px-3 focus:border-sky-500 hover:border-sky-500 text-grey-800 h-8 w-full',
const full_width = {
    label: ' text-gray-700 text-sm font-bold col-sm-12 whitespace-nowrap',
    input: 'form-input rounded border py-2 px-3 focus:border-sky-500 hover:border-sky-500 text-grey-800 h-20 w-full',
    inner: 'col-md-12'
};

const textClassification = {
    label: 'block mb-1 font-bold text-sm formkit-invalid:text-red-500 whitespace-nowrap',
    //input: 'w-full h-10 px-3 border-none text-base text-gray-700 placeholder-gray-400',
    input: 'form-input rounded border py-2 px-3 focus:border-sky-500 hover:border-sky-500 text-grey-800 h-8 w-full',

}
const boxClassification = {
    fieldset: 'border border-gray-200 rounded px-2 pb-1',
    legend: 'font-bold text-sm',
    wrapper: '$reset flex items-center mb-1 cursor-pointer',
    help: 'mb-2',
    input: 'form-check-input appearance-none h-5 w-5 mr-2 border border-gray-500 rounded-sm bg-white checked:bg-blue-500 focus:outline-none focus:ring-0 transition duration-200',
    label: 'text-sm text-gray-700 mt-1 whitespace-nowrap'
}
const buttonClassification = {
    wrapper: 'mb-1',
    input: 'bg-blue-500 hover:bg-blue-700 text-white text-sm font-normal py-3 px-5 rounded'
}

export default {
    inputs: {
        otp: createInput(OneTimePassword, {
            props: ['digits'],
        }),
        switch: createInput(Switch, {
            props: ['status'],
        }),
        dropzone: createInput(Dropzone, {
            props: ['status'],
        }),
        editor: createInput(Editor, {
            props: ['status'],
        }),
        face: createInput(Face, {
            props: ['status'],
        }),
        media: createInput(Media, {
            props: ['status'],
        }),
        recordpicker: createInput(RecordPicker, {
            props: ['status'],
        }),
        recordselect: createInput(RecordSelect, {
            props: ['status'],
        }),
        datepicker: createInput(DatePicker, {
            props: ['status'],
        }),
        datetimepicker: createInput(DateTimePicker, {
            props: ['status'],
        }),
        daterangepicker: createInput(DateRangePicker, {
            props: ['status'],
        }),
        monthpicker: createInput(MonthPicker, {
            props: ['status'],
        }),
        timepicker: createInput(TimePicker, {
            props: ['status'],
        }),
        weekpicker: createInput(WeekPicker, {
            props: ['status'],
        }),
        yearpicker: createInput(YearPicker, {
            props: ['status'],
        }),
    },
    config: {
        classes: generateClasses({
            global: {
                outer: 'form-group  mb-1 formkit-disabled:opacity-50',
                help: 'text-xs text-gray-500 italic',
                messages: 'list-none p-0 offset-md-4  mt-1 mb-2',
                label: ' text-gray-700 text-sm font-bold col-md-4  whitespace-nowrap',
                message: 'text-red-500 text-xs italic fs-10 w-lighter',
                wrapper: 'row',
                inner: 'col-md-8'
            },


            button: buttonClassification,
            color: {
                label: 'block mb-1 font-bold text-sm',
                input: 'w-16 h-8 appearance-none cursor-pointer border border-gray-300 rounded-md mb-2 p-1'
            },
            date: textClassification,
            'datetime-local': textClassification,
            checkbox: {
                ...boxClassification,
                inner: '$reset ',
                label: '$reset text-gray-700 text-sm font-bold mt-1 whitespace-nowrap'
            },
            email: textClassification,
            file: {
                label: 'block mb-1 font-bold text-sm',
                inner: 'max-w-md cursor-pointer',
                input: 'text-gray-600 text-sm mb-1 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:bg-blue-500 file:text-white hover:file:bg-blue-600',
                noFiles: 'block text-gray-800 text-sm mb-1',
                fileItem: 'block flex text-gray-800 text-sm mb-1',
                removeFiles: 'ml-auto text-blue-500 text-sm'
            },
            month: textClassification,
            number: textClassification,
            password: textClassification,
            radio: {
                // if we want to override a given sectionKey
                // from a classification we can do a spread
                // of the default value along with a new
                // definition for our target sectionKey.
                ...boxClassification,
                input: boxClassification.input.replace('rounded-sm', 'rounded-full'),
                inner: '$reset ',
                label: '$reset text-gray-700 text-sm font-bold mt-1 whitespace-nowrap'
            },
            range: {
                inner: 'max-w-md',
                input: 'form-range appearance-none w-full h-2 p-0 bg-gray-200 rounded-full focus:outline-none focus:ring-0 focus:shadow-none'
            },
            search: textClassification,
            select: {
                ...textClassification,
                input: textClassification.input.replace('form-input', 'form-select').replace('py-2', 'py-0'),
            },
            submit: buttonClassification,
            tel: textClassification,
            text: textClassification,
            textarea: {
                ...textClassification,
                input: textClassification.input + ' h-20 ',
                messages: '$reset list-none p-0 mt-1 mb-2',
                inner: '$reset col-md-12'
            },
            time: textClassification,
            url: textClassification,
            week: textClassification,

            editor: full_width,
            dropzone: full_width,
            media: full_width,
            switch: {
                wrapper: 'row',
                label: 'text-gray-700 text-sm font-bold col-6 col-md-4 whitespace-nowrap',
                inner: 'col-6'
            }
        }),

    }
}
