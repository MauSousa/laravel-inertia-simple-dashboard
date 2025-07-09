<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { Product, type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { useForm } from 'laravel-precognition-vue-inertia';
import { LoaderCircle } from 'lucide-vue-next';

interface Props {
    product: Product;
}

const props = defineProps<Props>();
const image = props.product.image ? `/storage/products/${props.product.image}` : '/storage/products/product_placeholder.png';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: route('products.index'),
    },
    {
        title: `Show ${props.product.name}`,
        href: route('products.show', props.product.id),
    },
    {
        title: `Edit ${props.product.name}`,
        href: '',
    },
];

const form = useForm('patch', route('products.update', props.product), {
    name: props.product.name,
    description: props.product.description,
    price: props.product.price,
    image: null,
});

form.setValidationTimeout(500);
form.validateFiles();

const submit = () => {
    router.post(
        route('products.update', props.product),
        {
            _method: 'patch',
            ...form.data(),
        },
        {
            preserveScroll: true,
            onSuccess: () => form.reset('name', 'description', 'price', 'image'),
        },
    );
};
</script>

<template>

    <Head title="Edit Product" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid min-h-[100vh] grid-cols-4 gap-2 rounded-xl">
                <form @submit.prevent="submit" class="col-span-3 flex flex-col gap-6">
                    <div class="grid gap-6">
                        <div class="grid gap-2">
                            <Label for="name"> Name of Product </Label>
                            <Input id="name" type="text" required autofocus placeholder="Name of Product" :tabindex="1"
                                v-model="form.name" @change="form.validate('name')" />
                            <InputError :message="form.errors.name" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="price"> Price of Product </Label>
                            <Input id="price" type="number" required autofocus placeholder="Price of Product"
                                :tabindex="2" v-model="form.price" @change="form.validate('price')" />
                            <InputError :message="form.errors.price" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="description"> Description </Label>
                            <Input id="description" type="text" placeholder="Description" :tabindex="3"
                                v-model="form.description" @change="form.validate('description')" />
                            <InputError :message="form.errors.description" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="image"> Image of the product </Label>
                            <Input id="image" type="file" @input="form.image = $event.target.files[0]"
                                @change="form.validate('image')" :tabindex="4" />
                            <InputError :message="form.errors.image" />
                        </div>
                        <Button type="submit" class="mt-2 w-full" tabindex="5" :disabled="form.processing">
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                            Update product
                        </Button>
                    </div>
                </form>
                <div class="col-span-1"><img :src="image" class="w-full rounded-xl" /></div>
            </div>
        </div>
    </AppLayout>
</template>
