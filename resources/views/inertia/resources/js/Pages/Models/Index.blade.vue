@php
    $columns = collect($model->table->columns)->filter(function($col){ return !str($col->name)->matches('/id|created_at|updated_at|deleted_at/');});
    $col_names = $columns->map(function($col) { return "'".str($col->name)->human()->title()."'"; })->implode(",");
@endphp
<template>
    <app-layout>
        <template #header> {{str($model->name)->plural()->human()->title()}} </template>
        <container>
            <div class="space-y-2">
                <div class="flex justify-end">
                    <inertia-link
                        :href="route('{{str($model->name)->snake()->slug()->plural()}}.create')"
                        class="px-4 py-2 text-white rounded bg-primary-600 hover:bg-primary-600 text-sm font-medium">
                    New
                    </inertia-link>
                </div>
                <table-base :headers="[{!!$col_names!!}, '']">
                    <tr
                        v-for="(item, idx) in {{str($model->name)->plural()->snake()}}.data"
                        :key="idx"
                        class="bg-white even:bg-gray-50 hover:bg-gray-100"
                    >
@foreach($columns->pluck('name') as $col)
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                            {{code()->doubleCurlyOpen()}}item.{{ $col }}{{code()->doubleCurlyClose()}}

                        </td>
@endforeach
                        <td class="px-6 py-4 text-sm font-semibold text-right whitespace-nowrap">
                            <div class="inline-flex space-x-1.5">
                                <inertia-link :href="route('{{str($model->name)->snake()->slug()->plural()}}.edit',item.id)">
                                    <PencilAltIcon
                                        class="w-5 h-5 cursor-pointer text-gray-300 hover:text-primary-500"
                                        aria-hidden="true"
                                    />
                                </inertia-link>
                                <inertia-link
                                    method="delete"
                                    :href="route('{{str($model->name)->snake()->slug()->plural()}}.destroy', item.id)"
                                >
                                <TrashIcon
                                    class="w-5 h-5 text-gray-300 hover:text-red-400"
                                    aria-hidden="true"
                                />
                                </inertia-link>
                            </div>
                        </td>
                    </tr>
                    <template #pagination>
                        <pagination :items="{{str($model->name)->plural()->snake()}}"></pagination>
                    </template>
                </table-base>
            </div>
        </container>
    </app-layout>
</template>
<script>
import { TrashIcon,PencilAltIcon, } from "@heroicons/vue/outline"
import TableBase from "@/Shared/TableBase.vue";
import AppLayout from "@/Layouts/AppLayout";
import Container from "@/Shared/Container";
import Pagination from "@/Shared/Pagination";
export default {
    name: "Index",
    components: { AppLayout, Container, TableBase, TrashIcon, PencilAltIcon, Pagination },
    props: { {{str($model->name)->plural()->snake()}}: Object },
    setup() {},
};
</script>