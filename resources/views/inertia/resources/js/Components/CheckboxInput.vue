<template>
    <label :for="name" class="flex items-center mr-3 text-sm font-medium text-gray-700 ">
      <input
        :id="id"
        :name="name"
        type="checkbox"
        class="w-4 h-4 mr-2 border-gray-300 rounded"
        @input="$emit('update:value', $event.target.checked)"
      />
      <span class="inline-block">
        {{ label }}
      </span>
      </label>
</template>
<script>

export default {
    inheritAttrs: false,
    props: {
        id: {
            type: String,
        },
        name: String,
        value: Boolean,
        label: String,
        error: String,
    },
    setup() {
    },
    emits:['update:value']
}
</script>
