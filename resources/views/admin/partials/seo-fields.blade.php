<div class="mt-6 pt-6 border-t border-gray-200">
    <h3 class="text-sm font-semibold text-gray-900 mb-4">SEO (search &amp; social)</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Meta title</label>
            <input type="text" name="meta_title" value="{{ old('meta_title', $model->meta_title ?? '') }}"
                   placeholder="Leave blank to use the main title"
                   class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Meta description</label>
            <textarea name="meta_description" rows="2" maxlength="500"
                      placeholder="Short summary for Google and social previews (max 500 chars)"
                      class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">{{ old('meta_description', $model->meta_description ?? '') }}</textarea>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Open Graph image URL</label>
            <input type="url" name="og_image" value="{{ old('og_image', $model->og_image ?? '') }}"
                   placeholder="https://… (optional preview image for social shares)"
                   class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-sm">
        </div>
    </div>
</div>
