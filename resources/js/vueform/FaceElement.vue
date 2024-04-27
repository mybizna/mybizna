<!-- CustomElement.vue -->

<template>
    <ElementLayout>
        <template #element>
            <div class="flex items-center space-x-6">
                <div class="shrink-0">
                    <img class="h-16 w-16 object-cover rounded-full"
                        src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1361&q=80"
                        alt="Current profile photo" />
                </div>
                <label class="block ">
                    <span class="sr-only">Choose profile photo</span>
                    <FileElement accept=".jpg,.png,.gif" view="image"  />
                </label>
            </div>
        </template>

        <!-- Default element slots -->
        <template v-for="(component, slot) in elementSlots" #[slot]>
            <slot :name="slot" :el$="el$">
                <component :is="component" :el$="el$" />
            </slot>
        </template>
    </ElementLayout>
</template>
  
<script>
import { defineElement } from '@vueform/vueform'

export default defineElement({
    name: 'FaceElement',
    setup(props, { element }) {
        // ...
    }
})
</script>

