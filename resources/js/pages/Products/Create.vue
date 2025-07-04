<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { useForm } from 'laravel-precognition-vue-inertia';
import { LoaderCircle } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: '/products',
    },
    {
        title: 'Create Product',
        href: '/products/create',
    },
];

const form = useForm('post', route('products.store'), {
    name: '',
    description: '',
    price: 0,
    image: null,
});

form.setValidationTimeout(500);
form.validateFiles();

const submit = () => {
    form.post(route('products.store'), {
        onSuccess: () => form.reset('name', 'description', 'price', 'image'),
    });
};
</script>

<template>
    <Head title="Create Product" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl">
                <form @submit.prevent="submit" class="flex flex-col gap-6">
                    <div class="grid gap-6">
                        <div class="grid gap-2">
                            <Label for="name"> Name of Product </Label>
                            <Input
                                id="name"
                                type="text"
                                required
                                autofocus
                                placeholder="Name of Product"
                                :tabindex="1"
                                v-model="form.name"
                                @change="form.validate('name')"
                            />
                            <InputError :message="form.errors.name" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="price"> Price of Product </Label>
                            <Input
                                id="price"
                                type="number"
                                required
                                autofocus
                                placeholder="Price of Product"
                                :tabindex="2"
                                v-model="form.price"
                                @change="form.validate('price')"
                            />
                            <InputError :message="form.errors.price" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="description"> Description </Label>
                            <Input
                                id="description"
                                type="text"
                                placeholder="Description"
                                :tabindex="2"
                                v-model="form.description"
                                @change="form.validate('description')"
                            />
                            <InputError :message="form.errors.description" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="image"> Image of the product </Label>
                            <Input
                                id="image"
                                type="file"
                                @input="form.image = $event.target.files[0]"
                                @change="form.validate('image')"
                                :tabindex="3"
                            />
                            <InputError :message="form.errors.image" />
                        </div>
                        <Button type="submit" class="mt-2 w-full" tabindex="5" :disabled="form.processing">
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                            Create product
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
