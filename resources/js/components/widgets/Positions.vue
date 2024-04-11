<template>
  <template v-for="(component, index) in components" :key="index">
    <div v-if="component.has_wrapper" class=" my-4">
      <div class="">
        <component :is="component.render"></component>
      </div>
    </div>
    <component v-else :is="component.render"></component>
  </template>
</template>

<script>
export default {
  props: {
    name: String,
  },
  watch: {
    '$store.state.system.positions'(newValue, oldValue) {
      // Do something when myState changes
      console.log('oldValue');
      console.log(oldValue);
      console.log('newValue');
      console.log(newValue);
    }
  },
  data() {
    return {
      components: []
    };
  },
  created() {
    this.$store.state.system.positions[this.name].forEach(position => {
      position['render'] = window.$func.fetchComponent(position.path)
      this.components.push(position);
    });
  }

};
</script>
