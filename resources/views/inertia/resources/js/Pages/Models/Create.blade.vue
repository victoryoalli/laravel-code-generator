@php
    $columns = collect($model->table->columns)->filter(function($col){ return !str($col->name)->matches('/id|created_at|updated_at/');});
    $form_cols = $columns->map(function($col) { return str($col->name).":''"; })->implode(",");
@endphp
<template>
    <app-layout>
        <template #header> Size Scales Create </template>
        <container>
            <div class="space-y-6">
                <div class="px-4 py-5 bg-white shadow rounded">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium text-gray-900">
                                {{str($model->name)->human()->title()}} Information
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </p>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form @submit.prevent="store">
                                <div class="grid grid-cols-6 gap-6">
@foreach($columns->pluck('name') as $col)
                                    <div class="col-span-6 sm:col-span-6">
                                        <text-input
                                            :value="form.{{$col}}"
                                            @update:value="form.{{$col}}= $event"
                                            :error="errors.{{$col}}"
                                            class=""
                                            label="{{str($col)->human()->title()}}"
                                        />
                                    </div>
@endforeach
                                </div>
                                <div class="flex justify-end mt-4">
                                    <inertia-link
                                        :href="route('{{str($model->name)->snake()->slug()->plural()}}.index')"
                                        type="button"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50"
                                    >
                                        Cancel
                                    </inertia-link>
                                    <button
                                        :disabled="form.processing"
                                        type="submit"
                                        class="inline-flex justify-center px-4 py-2 ml-3 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary-600 hover:bg-primary-700"
                                    >
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </container>
    </app-layout>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout";
import Container from "@/Shared/Container";
import TextInput from "@/Shared/TextInput"
export default {
    props:{errors: Object},
    components: {AppLayout,Container, TextInput},
    setup() {
        const form = useForm({
            {!!$form_cols!!},
        });
        function store() {
            form.post(route('{{str($model->name)->snake()->slug()->plural()}}.store'));
        }
        return { form, store };
    },
};
</script>