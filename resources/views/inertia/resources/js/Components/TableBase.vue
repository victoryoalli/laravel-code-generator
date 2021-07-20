<template>
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
        <div
          class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg"
        >
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th
                  v-for="(header, index) in headers"
                  :key="index"
                  scope="col"
                  class="px-6 py-4 font-medium text-left text-gray-600"
                >
                  {{ header }}
                </th>
              </tr>
            </thead>
            <tbody>
              <slot />
            </tbody>
          </table>

          <slot name="pagination" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "TableBase",
  data() {
    return {
      items: 3,
    };
  },
  props: {
    headers: {
      type: Array,
      required: true,
    },
  },
};
</script>
