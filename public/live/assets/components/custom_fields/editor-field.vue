<template>
    <editor  v-model="value" :init="{plugins: 'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table contextmenu directionality emoticons template paste textcolor', toolbar:'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | forecolor backcolor emoticons'}"></editor>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
import { abstractField } from "vue-form-generator";

export default {
  mixins: [abstractField],
  components: {
    editor: Editor // <- Important part
  }
};
</script>