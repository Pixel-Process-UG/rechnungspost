<template>
  <div>
    <nav class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <NuxtLink to="/" class="text-xl font-bold text-brand-700">Rechnungspost</NuxtLink>
          </div>
          <div class="flex items-center space-x-4">
            <NuxtLink to="/dashboard" class="text-gray-600 hover:text-gray-900">Dashboard</NuxtLink>
            <NuxtLink to="/invoices" class="text-gray-600 hover:text-gray-900">Invoices</NuxtLink>
          </div>
        </div>
      </div>
    </nav>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <slot />
    </main>
  </div>
</template>
