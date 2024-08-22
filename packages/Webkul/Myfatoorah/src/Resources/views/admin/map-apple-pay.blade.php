<x-admin::layouts>
    <!-- Title of the page -->
    <x-slot:title>
        @lang('my_fatoorah::app.admin.settings.map-apple-pay.title')
    </x-slot:title>

    <!-- Category Create Form -->
    <x-admin::form
        :action="route('myfatoorah.settings.map-apple-pay')"
        enctype="multipart/form-data"
    >
        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                @lang('my_fatoorah::app.admin.settings.map-apple-pay.title')
            </p>

            <div class="flex items-center gap-x-2.5">
                <!-- Cancel Button -->
                <a
                    href="{{ route('myfatoorah.settings.map-apple-pay') }}"
                    class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800"
                >
                    @lang('my_fatoorah::app.admin.settings.map-apple-pay.back-btn')
                </a>

                <!-- Save Button -->
                <button
                    type="submit"
                    class="primary-button"
                >
                    @lang('my_fatoorah::app.admin.settings.map-apple-pay.save-btn')
                </button>
            </div>
        </div>

        <!-- Full Pannel -->
        <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
            <div class="box-shadow w-full rounded bg-white p-4 dark:bg-gray-900">
                <!-- Seller -->
                <x-admin::form.control-group class="mb-2.5 w-full">
                    <x-admin::form.control-group.label class="required">
                        @lang('my_fatoorah::app.admin.settings.map-apple-pay.url')
                    </x-admin::form.control-group.label>
                    
                    <x-admin::form.control-group.control
                        type="text"
                        name="domain"
                        :value="request()->getHost()"
                        :label="trans('my_fatoorah::app.admin.settings.map-apple-pay.url')"
                        :required="true"
                    />

                    <x-admin::form.control-group.error
                        class="mt-3"
                        control-name="domain"
                    />
                </x-admin::form.control-group>
            </div>
        </div>
    </x-admin::form>
</x-admin::layouts>
