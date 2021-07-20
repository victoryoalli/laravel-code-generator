@php
    $columns = collect($model->table->columns)->filter(function($col){ return !str($col->name)->matches('/id|created_at|updated_at|deleted_at/');});
    $m = $model;
@endphp
<template>
	<app-layout>
        <template #header> {{str($model->name)->plural()->human()->title()}} Edit </template>
        <container>
            <div class="space-y-6">
                <div class="px-4 py-5 bg-white shadow sm:rounded-lg sm:p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium text-gray-900">
                                {{str($model->name)->human()->title()}} Information
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </p>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form @submit.prevent="update">
                                <div class="grid grid-cols-6 gap-6">
@foreach($model->relations as $rel)
@if($rel->type === 'BelongsTo')
                                    <div class="col-span-6 sm:col-span-6">
                                        <select-input
                                            :value="form.{{$rel->local_key}}"
                                            @update:value="form.{{$rel->local_key}} = $event"
                                            :error="errors.{{$rel->local_key}}"
                                            class="block w-full px-3 py-2.5 mt-1 bg-white border rounded"
                                            label="{{str($rel->name)->title()}}"
                                        >
                                        <option value="null">-</option>
                                        <option
                                            :value="{{$rel->name}}.id"
                                            v-for="({{$rel->name}}, idx) in {{str($rel->name)->snake()->plural()}}"
                                            :key="idx"
                                        >
                                            {{code()->doubleCurlyOpen()}}{{$rel->name}}.{{collect($rel->model->table->columns)->filter(function($col,$key) {
                                                return $col->type == 'String'; })->map(function($col){ return $col->name;})->first()}}{{code()->doubleCurlyClose()}}
                                        </option>
                                        </select-input>
                                    </div>
@endif
@endforeach
@foreach($columns->pluck('name') as $col)
                                    <div class="col-span-6 sm:col-span-6">
                                        <text-input
                                            :value="form.{{$col}}"
                                            @update:value="form.{{$col}}= $event"
                                            :error="errors.{{$col}}"
                                            class="shadow"
                                            label="{{str($col)->human()->title()}}"
                                        />
                                    </div>
@endforeach
                                </div>
                                <div class="flex justify-end mt-4">
                                    <inertia-link
                                        :href="route('{{str($model->name)->snake()->slug()->plural()}}.index')"
                                        type="button"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded shadow hover:bg-gray-50"
                                    >
                                        Cancelar
                                    </inertia-link>
                                    <button
                                        :disabled="form.processing"
                                        type="submit"
                                        class="inline-flex justify-center px-4 py-2 ml-3 text-sm font-medium text-white border border-transparent rounded shadow bg-primary-600 hover:bg-primary-700"
                                    >
                                        Guardar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

@foreach($model->relations as $rel)
@if($rel->type === 'HasMany')
@php
    $columns = collect($rel->model->table->columns)->filter(function($col){ return !str($col->name)->matches('/id|created_at|updated_at|deleted_at/');});
    $col_names = $columns->map(function($col) { return "'".str($col->name)->human()->title()."'"; })->implode(",");
    $model = $rel->model;
@endphp
            <h2 class="mt-12 font-bold text-2xl">{{str($rel->name)->human()->title()}}</h2>
            <div class="bg-white rounded-md shadow overflow-x-auto">
                <table-base :headers="[{!!$col_names!!}, '']">

                    <tr v-for="{{str($model->name)->snake()}} in {{str($rel->name)->snake()}}.data" :key="{{str($model->name)->snake()}}.id" class="bg-white even:bg-gray-50 hover:bg-gray-100">
@foreach($columns->pluck('name') as $col)
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                            {{code()->doubleCurlyOpen()}}{{str($model->name)->snake()}}.{{ $col }}{{code()->doubleCurlyClose()}}
                        </td>
@endforeach
                        <td class="px-6 py-4 text-sm font-semibold text-right whitespace-nowrap">
                            <div class="inline-flex space-x-1.5">
                                <inertia-link :href="route('{{str($model->name)->snake()->slug()->plural()}}.edit',{{str($model->name)->snake()}}.id)">
                                    <PencilAltIcon
                                        class="w-5 h-5 cursor-pointer text-gray-300 hover:text-primary-600"
                                        aria-hidden="true"
                                    />
                                </inertia-link>
                                <inertia-link
                                    method="delete"
                                    :href="route('{{str($model->name)->snake()->slug()->plural()}}.destroy', {{str($model->name)->snake()}}.id)"
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
                        <pagination :items="{{str($rel->name)->snake()}}"></pagination>
                    </template>
                </table-base>
            </div>
@endif
@endforeach
        </container>
    </app-layout>
</template>
@php
    $rels = collect($m->relations)
    ->filter(function($rel){ return $rel->type === 'BelongsTo'; })
        ->map(function($rel){
            if($rel->type === 'BelongsTo')
                return str($rel->name)->snake()->plural().":Object";
            elseif($rel->type === 'HasMany')
                return str($rel->name)->snake().":Object";
            })
        ->implode(",");
@endphp
<script>
import { TrashIcon,PencilAltIcon, } from "@heroicons/vue/outline"
import { useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout";
import Container from "@/Shared/Container";
import TableBase from "@/Shared/TableBase"
import Pagination from "@/Shared/Pagination";
import TextInput from "@/Shared/TextInput"
import SelectInput from "@/Shared/SelectInput"
import CheckboxInput from "@/Shared/CheckboxInput"
export default {
    props:{ {{str($model->name)->snake()}}: Object ,errors: Object, {{$rels}} },
    components: { AppLayout, Container, TableBase, Pagination, TextInput, SelectInput, CheckboxInput, PencilAltIcon, TrashIcon },
    setup(props) {
        const form = useForm(props.{{str($model->name)->snake()}});
        function update() {
            form.put(route('{{str($model->name)->snake()->slug()->plural()}}.update',form.id));
        }
        return { form, update };
    },
    mounted() {},
};
</script>