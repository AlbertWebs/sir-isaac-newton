# Form Styling Guide

This document outlines the beautiful form styling pattern used throughout the Sir Isaac Newton School Management System.

## Design Principles

1. **White Background**: All forms maintain a clean white background
2. **Gradient Headers**: Each form has a colorful gradient header for visual appeal
3. **Subtle Shadows**: Forms use layered shadows (shadow-sm → hover:shadow-md → focus:shadow-lg)
4. **Smooth Animations**: Transitions are subtle (200ms duration) and enhance UX without being distracting
5. **Color-Coded Sections**: Different forms use different color themes (blue, purple, green, etc.)

## Form Structure

### 1. Form Container
```html
<div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
    <!-- Form Header -->
    <div class="bg-gradient-to-r from-[COLOR]-600 to-[COLOR]-600 px-6 py-4">
        <h2 class="text-2xl font-bold text-white">Form Title</h2>
        <p class="text-[COLOR]-100 text-sm mt-1">Form description</p>
    </div>

    <form method="POST" action="..." class="p-6">
        <!-- Form fields -->
    </form>
</div>
```

### 2. Section Headers
```html
<div class="md:col-span-2">
    <div class="flex items-center mb-6">
        <div class="flex-shrink-0 w-1 h-8 bg-gradient-to-b from-[COLOR]-500 to-[COLOR]-500 rounded-full mr-3"></div>
        <h3 class="text-lg font-semibold text-gray-800">Section Title</h3>
    </div>
</div>
```

### 3. Form Input Fields
```html
<div class="group">
    <label for="field_name" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-[COLOR]-600 transition-colors">
        <span class="flex items-center">
            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-[COLOR]-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <!-- SVG path -->
            </svg>
            Field Label *
        </span>
    </label>
    <input 
        type="text" 
        id="field_name" 
        name="field_name" 
        required
        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[COLOR]-500 focus:border-[COLOR]-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white"
        placeholder="Placeholder text"
    >
    @error('field_name')
        <p class="text-red-500 text-xs mt-1.5 flex items-center">
            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            {{ $message }}
        </p>
    @enderror
</div>
```

### 4. Select Dropdowns
```html
<select 
    id="field_name" 
    name="field_name" 
    required
    class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[COLOR]-500 focus:border-[COLOR]-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white cursor-pointer"
>
    <option value="">Select option...</option>
    <!-- Options -->
</select>
```

### 5. Textareas
```html
<textarea 
    id="field_name" 
    name="field_name" 
    rows="3"
    class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[COLOR]-500 focus:border-[COLOR]-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white resize-none"
    placeholder="Placeholder text"
></textarea>
```

### 6. Form Actions (Buttons)
```html
<div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end gap-4">
    <a href="..." 
        class="px-6 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium shadow-sm hover:shadow">
        Cancel
    </a>
    <button type="submit" 
        class="px-6 py-2.5 bg-gradient-to-r from-[COLOR]-600 to-[COLOR]-600 text-white rounded-lg hover:from-[COLOR]-700 hover:to-[COLOR]-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
        <span class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <!-- SVG path -->
            </svg>
            Submit Button
        </span>
    </button>
</div>
```

## Color Themes by Form Type

- **Classes Management**: Blue/Indigo (`from-blue-600 to-indigo-600`)
- **Subjects Management**: Purple/Indigo (`from-purple-600 to-indigo-600`)
- **Billing/Payments**: Green/Emerald (`from-green-600 to-emerald-600`)
- **Routes/Transport**: Orange/Amber (`from-orange-600 to-amber-600`)
- **Announcements**: Pink/Rose (`from-pink-600 to-rose-600`)
- **Clubs**: Teal/Cyan (`from-teal-600 to-cyan-600`)

## Key CSS Classes

### Input States
- `border-2 border-gray-200` - Default border
- `focus:ring-2 focus:ring-[COLOR]-500` - Focus ring
- `focus:border-[COLOR]-500` - Focus border color
- `shadow-sm hover:shadow-md focus:shadow-lg` - Progressive shadows
- `transition-all duration-200` - Smooth transitions

### Label States
- `group-focus-within:text-[COLOR]-600` - Label color on focus
- `transition-colors` - Smooth color transitions

### Button States
- `bg-gradient-to-r from-[COLOR]-600 to-[COLOR]-600` - Gradient background
- `hover:from-[COLOR]-700 hover:to-[COLOR]-700` - Darker on hover
- `shadow-lg hover:shadow-xl` - Enhanced shadow on hover
- `transform hover:-translate-y-0.5` - Subtle lift on hover

## Icons

Each form field includes a relevant SVG icon that:
- Changes color on focus (gray-400 → [COLOR]-500)
- Provides visual context for the field
- Enhances the overall design

Common icons used:
- User/Person: `<path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>`
- Book/Education: `<path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>`
- Money/Currency: `<path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>`
- Clock/Time: `<path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>`

## Examples

See the following files for complete examples:
- `resources/views/admin/classes/create.blade.php`
- `resources/views/admin/subjects/create.blade.php`
- `resources/views/billing/index.blade.php`

## Notes

- All animations use `duration-200` for consistency
- Shadows progress from `shadow-sm` → `hover:shadow-md` → `focus:shadow-lg`
- Form headers use gradient backgrounds for visual appeal
- Section dividers use colored vertical bars for hierarchy
- Error messages include icons for better visibility
- Help text uses info icons for clarity

