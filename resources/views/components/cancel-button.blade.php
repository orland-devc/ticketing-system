<button {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-bold text-xs text-black uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-100 active:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
