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
        title: 'Users',
        href: '/users',
    },
    {
        title: 'Create User',
        href: '/users/create',
    },
];

const form = useForm('post', route('users.store'), {
    name: '',
    email: '',
});

form.setValidationTimeout(500);

const submit = () => {
    form.post(route('users.store'), {
        onSuccess: () => form.reset('name', 'email'),
    });
};
</script>

<template>
    <Head title="Create User" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl">
                <form @submit.prevent="submit" class="flex flex-col gap-6">
                    <div class="grid gap-6">
                        <div class="grid gap-2">
                            <Label for="name"> Full Name </Label>
                            <Input
                                id="name"
                                type="text"
                                required
                                autofocus
                                placeholder="Full name"
                                :tabindex="1"
                                v-model="form.name"
                                @change="form.validate('name')"
                            />
                            <InputError :message="form.errors.name" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="description"> Email </Label>
                            <Input
                                id="description"
                                type="email"
                                placeholder="Email"
                                :tabindex="2"
                                v-model="form.email"
                                @change="form.validate('email')"
                            />
                            <InputError :message="form.errors.email" />
                        </div>
                        <Button type="submit" class="mt-2 w-full" tabindex="3" :disabled="form.processing">
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                            Create user
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
