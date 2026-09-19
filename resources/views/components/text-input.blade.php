@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#DD2494] dark:focus:border-[#DD2494] focus:ring-[#DD2494] dark:focus:ring-[#DD2494] rounded-md shadow-sm']) }}>
