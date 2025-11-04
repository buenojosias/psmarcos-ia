<div>
    <x-slot name="title">Dashboard</x-slot>
    <div class="w-full h-[85vh] mb-8 flex flex-col items-center justify-center">
        <x-ts-icon name="sparkles" class="mb-8 w-20 h-20 text-gray-500" outline />
        <h2 class="w-2/3 md:w-1/2 mb-4 text-center text-gray-800 dark:text-gray-200">Bem vindo(a) ao assistente de AI da
            Paróquia São Marcos</h2>
        <h3 class="w-2/3 md:w-1/2 mb-8 text-center text-gray-600 dark:text-gray-400">Este sistema é destinado à
            alimentação de informações sobre a paróquia para o assistente de atendimento de WhatsApp.</h3>
        {{-- <div class="md:mt-8 grid grid-cols-1 lg:grid-cols-3 gap-4">
            <x-ts-stats title="Seus grupos" :number="$pastorals" icon="user-group" />
            <x-ts-stats title="Eventos" :number="100" icon="calendar" />
            <x-ts-stats title="Perguntas cadastradas" :number="100" icon="question-mark-circle" />
        </div> --}}
    </div>
</div>
