<template>
  <div>
    <label
      v-if="label"
      :for="id"
      class="block text-sm font-medium text-gray-700"
      >{{ label }}</label
    >
    <input
      :id="id"
      v-bind="$attrs"
      class="block w-full mt-1 border-gray-300 rounded-md"
      :class="{ 'border border-red-500': error }"
      :type="type"
      :value="value"
      @input="$emit('update:value', $event.target.value)"
    />
    <div class="mt-0.5 text-xs text-red-500" v-if="error">{{ error }}</div>
  </div>
</template>

<script>


export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
    },
    type: {
      type: String,
      default: "text",
    },
    value: String|Number,
    label: String,
    error: String,
  },
  emits: ['update:value'],
  setup() {
  },
};
</script>
