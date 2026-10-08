<template>
  <div>
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Dashboard</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-sm font-medium text-gray-500">Total Invoices</h3>
        <p class="mt-2 text-3xl font-bold text-gray-900">—</p>
      </div>
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-sm font-medium text-gray-500">Pending Validation</h3>
        <p class="mt-2 text-3xl font-bold text-yellow-600">—</p>
      </div>
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-sm font-medium text-gray-500">Forwarded</h3>
        <p class="mt-2 text-3xl font-bold text-green-600">—</p>
      </div>
    </div>
  </div>
</template>
