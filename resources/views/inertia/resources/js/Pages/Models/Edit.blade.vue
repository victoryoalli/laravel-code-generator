@php
    $columns = collect($model->table->columns)->filter(function($col){ return !str($col->name)->matches('/id|created_at|updated_at/');});
@endphp
<template>
	<app-layout>
        <template #header> {{str($model->name)->plural()->human()->title()}} Edit </template>
        <container>
            <div class="space-y-6">
                <div class="px-4 py-5 bg-white shadow sm:rounded-lg sm:p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                {{str($model->name)->human()->title()}} Information
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </p>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form @submit.prevent="update">
                                <div class="grid grid-cols-6 gap-6">
@foreach($columns->pluck('name') as $col)
                                    <div class="col-span-6 sm:col-span-6">
                                        <label for="name" class="block text-sm font-medium text-gray-700" >{{str($col)->human()->title()}}</label>
                                        <input
                                            v-model="form.{{$col}}"
                                            type="text"
                                            name="{{$col}}"
                                            id="{{$col}}"
                                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                        />
                                        <div class="text-xs text-red-500" v-if="errors.{{$col}}">{{code()->doubleCurlyOpen()}}errors.{{$col}}{{code()->doubleCurlyClose()}}</div>
                                    </div>
@endforeach
                                </div>
                                <div class="flex justify-end mt-4">
                                    <inertia-link
                                        :href="route('{{str($model->name)->plural()->slug()}}.index')"
                                        type="button"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                                    >
                                        Cancelar
                                    </inertia-link>
                                    <button
                                        :disabled="form.processing"
                                        type="submit"
                                        class="inline-flex justify-center px-4 py-2 ml-3 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
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
    $columns = collect($rel->model->table->columns)->filter(function($col){ return !str($col->name)->matches('/id|created_at|updated_at/');});
    $model = $rel->model;
@endphp
            <h2 class="mt-12 font-bold text-2xl">{{str($rel->name)->human()->title()}}</h2>
            <div class="bg-white rounded-md shadow overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <tr class="text-left font-bold">
@foreach($columns as $col)
                    <th class="px-6 pt-6 pb-4">{{str($col->name)->human()->title()}}</th>
@endforeach
                    <th class="px-6 pt-6 pb-4"></th>
                    </tr>

                    <tr v-for="{{str($model->name)->snake()}} in {{str($rel->name)->snake()}}.data" :key="{{str($model->name)->snake()}}.id" class="bg-white even:bg-gray-50 hover:bg-gray-100">
@foreach($columns->pluck('name') as $col)
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                            {{code()->doubleCurlyOpen()}}item.{{ $col }}{{code()->doubleCurlyClose()}}
                        </td>
@endforeach
                        <td class="px-6 py-4 text-sm font-semibold text-right whitespace-nowrap">
                            <div class="inline-flex space-x-1.5">
                                <inertia-link :href="route('{{str($model->name)->snake()->slug()->plural()}}.edit',item.id)">
                                    <PencilAltIcon
                                        class="w-5 h-5 cursor-pointer text-primary-500 hover:text-primary-600"
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
                    <tr v-if="organizations.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">No organizations found.</td>
                    </tr>
                </table>
            </div>
            <pagination class="mt-6" :links="{{str($model->name)->plural()->snake()}}" />
@endif
@endforeach
        </container>
    </app-layout>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout";
import Container from "@/Components/Container";
export default {
    props:{ {{str($model->name)->snake()}}: Object ,errors: Object },
    components: { AppLayout, Container },
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