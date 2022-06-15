import {
    createInput
} from '@formkit/vue';
import Dropzone from "@/formkit/inputs/Dropzone";
import Editor from "@/formkit/inputs/Editor";
import Face from "@/formkit/inputs/Face";
//import File from "@/formkit/inputs/File";
import Media from "@/formkit/inputs/Media";
import OneTimePassword from "@/formkit/inputs/OneTimePassword";
import RecordAutoComplete from "@/formkit/inputs/RecordAutoComplete";
import RecordPicker from "@/formkit/inputs/RecordPicker";
import RecordSelect from "@/formkit/inputs/RecordSelect";
import Switch from "@/formkit/inputs/Switch";

import {
    generateClasses
} from '@formkit/themes';

const full_width = {
    label: ' text-gray-700 text-sm font-bold col-sm-12',
    input: 'form-input rounded border py-2 px-3 focus:border-sky-500 hover:border-sky-500 text-grey-800 h-20 w-full',
    inner: 'col-md-12'
};

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
        recordautocomplete: createInput(RecordAutoComplete, {
            props: ['status'],
        }),
        recordpicker: createInput(RecordPicker, {
            props: ['status'],
        }),
        recordselect: createInput(RecordSelect, {
            props: ['status'],
        }),
    },
    config: {
        classes: generateClasses({
            global: {
                input: 'form-input rounded border py-2 px-3 focus:border-sky-500 hover:border-sky-500 text-grey-800 h-8 w-full',
                outer: "form-group  mb-1",
                help: 'text-gray-600 text-xs italic',
                label: ' text-gray-700 text-sm font-bold col-md-4',
                messages: 'list-none p-0 mt-0 mb-0',
                message: 'text-red-500 text-xs italic fs-10 w-lighter',
                wrapper: 'row',
                inner: 'col-md-8'
            },
            textarea: full_width,
            editor: full_width,
            dropzone: full_width,
            select: {
                input: 'form-select rounded border py-0 px-3 focus:border-sky-500 hover:border-sky-500 text-grey-800 h-8 w-full',
            },
            switch: {
                wrapper: 'row',
                label: 'text-gray-700 text-sm font-bold col-6 col-md-4',
                inner: 'col-6'
            }
        }),

    }
}
