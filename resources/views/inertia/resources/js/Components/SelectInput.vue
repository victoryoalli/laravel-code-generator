<template>
  <div>
    <label v-if="label" :for="id" class="block text-sm font-medium text-gray-700" >{{ label }}</label>
    <select v-on:change="$emit('update:value', $event.target.value)" :id="id" ref="input" v-model="selected" v-bind="$attrs" class="form-select" :class="{ error: error }">
      <slot />
    </select>
    <div class="text-xs text-red-500" v-if="error"> {{ error }} </div>
  </div>
</template>

<script>
import { ref } from '@vue/reactivity'
export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
    },
    value: [String, Number, Boolean],
    label: String,
    error: String,
  },
  emits: ['update:value'],
  setup(props,{emit}) {
    var selected = ref(props.value)

    return { selected }

  },
}
</script>
