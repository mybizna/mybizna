<script setup>
import { ref } from 'vue'

 import Editor from '@tinymce/tinymce-vue'

const props = defineProps({
    context: Object,
})

const digits = Number(props.context.digits)
const tmp = ref(props.context.value || '')

</script>

<template>

     <Editor
       :init="{
         height: 500,
         menubar: false,
         plugins: [
           'advlist autolink lists link image charmap print preview anchor',
           'searchreplace visualblocks code fullscreen',
           'insertdatetime media table paste code help wordcount'
         ],
         toolbar:
           'undo redo | formatselect | bold italic backcolor | \
           alignleft aligncenter alignright alignjustify | \
           bullist numlist outdent indent | removeformat | help'
       }"
     />

</template>
