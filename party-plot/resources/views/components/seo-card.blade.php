<div class="card">
    <div class="card-header">
        <h4>SEO Settings</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <x-input
                    label="Meta title"
                    name="meta_title"
                    :value="old('meta_title', $data->meta_title ?? null)"
                />
            </div>
            <div class="col-md-6">
                @php
                    $keyWords = [];

                    if (isset($data->meta_keywords) && !empty($data->meta_keywords)) {
                        !empty($data->meta_keywords) ? $data->meta_keywords = explode(',', $data->meta_keywords) : $data->meta_keywords = [];
                        $keyWords = array_map('trim', $data->meta_keywords);
                        $keyWords = array_combine($keyWords, $keyWords);

                        $keyWords == "" ? $keyWords = [] : $keyWords;
                    }
                @endphp
                <x-select
                    label="Meta keywords"
                    name="meta_keywords[]"
                    id="meta_keywords"
                    :options="$keyWords"
                    :selected="old('meta_keywords', $data->meta_keywords ?? [])"
                    placeholder="Select meta keywords"
                    data-tags="true" multiple
                />
            </div>
            <div class="col-md-12">
                <x-textarea
                    label="Meta description"
                    name="meta_description"
                    :value="old('meta_description', $data->meta_description ?? null)"
                />
            </div>
        </div>
    </div>
</div>
