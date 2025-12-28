@extends('layouts.app')

@section('title', 'Process Payment')
@section('page-title', 'Process Payment')

@section('content')
<div class="max-w-4xl mx-auto" x-data="billingForm()">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Form Header -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">Process Payment</h2>
            <p class="text-green-100 text-sm mt-1">Record a new payment for a student</p>
        </div>
        
        <form @submit.prevent="submitForm" method="POST" action="{{ route('billing.store') }}" class="p-6">
            @csrf

            <!-- Student Selection -->
            <div class="mb-6 group">
                <label class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-green-600 transition-colors">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Select Student *
                    </span>
                </label>
                <div class="relative" x-data="{ studentSearch: '', showStudentDropdown: false }">
                    <input 
                        type="text" 
                        x-model="studentSearch" 
                        @focus="showStudentDropdown = true"
                        @click.away="showStudentDropdown = false"
                        @input="showStudentDropdown = true"
                        placeholder="Search student by name or number..."
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white"
                        :value="selectedStudentName"
                        readonly
                    >
                    <input type="hidden" name="student_id" x-model="studentId" required>
                    <div x-show="showStudentDropdown" x-cloak class="absolute z-10 w-full mt-1 bg-white border-2 border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                        <div class="p-2">
                            @foreach($students as $student)
                                <div 
                                    class="px-3 py-2 hover:bg-blue-50 cursor-pointer rounded"
                                    x-show="!studentSearch || ('{{ strtolower($student->full_name . ' ' . $student->student_number) }}').includes(studentSearch.toLowerCase())"
                                    @click="studentId = '{{ $student->id }}'; selectedStudentName = '{{ $student->full_name }} ({{ $student->student_number }})'; studentSearch = ''; showStudentDropdown = false; loadStudentInfo();"
                                >
                                    <div class="font-medium text-gray-900">{{ $student->full_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $student->student_number }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div x-show="studentId" class="mt-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                        <span x-text="selectedStudentName"></span>
                        <button type="button" @click="studentId = ''; selectedStudentName = ''; loadStudentInfo();" class="ml-2 text-blue-600 hover:text-blue-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </span>
                </div>
            </div>

            <!-- Class Selection -->
            <div class="mb-6 group">
                <label for="class_id" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-green-600 transition-colors">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Select Class *
                    </span>
                </label>
                <select 
                    id="class_id" 
                    name="class_id" 
                    x-model="classId"
                    @change="loadClassInfo"
                    x-ref="classSelect"
                    required
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white cursor-pointer"
                >
                    <option value="">Choose a class...</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">
                            {{ $class->name }} ({{ $class->code }}) - {{ $class->level }}
                        </option>
                    @endforeach
                </select>
                <p x-show="studentClasses.length === 0 && studentId" class="mt-2 text-sm text-yellow-600">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    This student is not enrolled in any classes for the current academic year. Showing all available classes.
                </p>
                <p x-show="studentClasses.length > 0 && studentId" class="mt-2 text-sm text-green-600">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Showing enrolled classes for this student.
                </p>
            </div>

            <!-- Academic Year (Hidden - Auto-set) -->
            <input 
                type="hidden" 
                id="academic_year" 
                name="academic_year" 
                value="{{ $currentAcademicYear }}"
            >

            <!-- Term Selection -->
            <div class="mb-6 group">
                <label for="term" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-green-600 transition-colors">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Academic Term *
                    </span>
                </label>
                <select 
                    id="term" 
                    name="term" 
                    x-model="selectedTerm"
                    @change="loadTermClasses"
                    required
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white cursor-pointer"
                >
                    <option value="Term 1" {{ $currentTerm === 'Term 1' ? 'selected' : '' }}>Term 1 (January - April)</option>
                    <option value="Term 2" {{ $currentTerm === 'Term 2' ? 'selected' : '' }}>Term 2 (May - August)</option>
                    <option value="Term 3" {{ $currentTerm === 'Term 3' ? 'selected' : '' }}>Term 3 (September - December)</option>
                </select>
                <p class="mt-1 text-sm text-gray-500">Select the term this payment is for. School fees are paid per term.</p>
            </div>

            <!-- Class Info Display (No Price for Cashier) -->
            <div x-show="classInfo" class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Selected Class</p>
                        <p class="text-lg font-semibold text-gray-900" x-text="classInfo?.name"></p>
                        <p class="text-sm text-gray-500" x-text="classInfo?.code + ' - ' + (classInfo?.level || '')"></p>
                    </div>
                    @if(auth()->user()->isSuperAdmin())
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Term Fee</p>
                        <p class="text-xl font-bold text-blue-600" x-text="'KES ' + (classInfo?.price ? parseFloat(classInfo.price).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) : '0.00')"></p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Term Fee Amount -->
            <div class="mb-6 group">
                <label for="agreed_amount" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-green-600 transition-colors">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Term Fee Amount (KES) *
                    </span>
                </label>
                <input 
                    type="number" 
                    id="agreed_amount" 
                    name="agreed_amount" 
                    x-model="agreedAmount"
                    @input="syncAmountPaid"
                    step="0.01"
                    min="0"
                    required
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white text-lg font-semibold"
                    placeholder="0.00"
                >
                <p class="mt-2 text-sm text-gray-500 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Enter the term fee amount. This will automatically be set as the amount paid (no discounts allowed).
                </p>
            </div>

            <!-- Amount Paid (Auto-filled, read-only) -->
            <div class="mb-6 group">
                <label for="amount_paid" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Amount Paid (KES) *
                    </span>
                </label>
                <input 
                    type="number" 
                    id="amount_paid" 
                    name="amount_paid" 
                    x-model="amountPaid"
                    readonly
                    step="0.01"
                    min="0"
                    required
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg bg-gray-50 text-lg font-semibold cursor-not-allowed"
                    placeholder="0.00"
                >
                <p class="mt-2 text-sm text-gray-500 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Amount paid automatically matches the term fee amount (no discounts allowed).
                </p>
            </div>

            <!-- Payment Method -->
            <div class="mb-6 group">
                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-green-600 transition-colors">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Payment Method *
                    </span>
                </label>
                <select 
                    id="payment_method" 
                    name="payment_method" 
                    required
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white cursor-pointer"
                >
                    <option value="mpesa">M-Pesa</option>
                    <option value="cash">Cash</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
            </div>

            <!-- Notes -->
            <div class="mb-6 group">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-green-600 transition-colors">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Notes (Optional)
                    </span>
                </label>
                <textarea 
                    id="notes" 
                    name="notes" 
                    rows="3"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white resize-none"
                    placeholder="Additional notes..."
                ></textarea>
            </div>

            <!-- Payment Summary -->
            <div x-show="agreedAmount && amountPaid" class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Payment Summary</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Term Fee Amount:</span>
                        <span class="font-semibold" x-text="'KES ' + (agreedAmount ? parseFloat(agreedAmount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) : '0.00')"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Amount Paid:</span>
                        <span class="font-semibold" x-text="'KES ' + (amountPaid ? parseFloat(amountPaid).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) : '0.00')"></span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-gray-300">
                        <span class="text-gray-600">Status:</span>
                        <span class="font-bold text-green-600">Fully Paid</span>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-4">
                <a href="{{ route('dashboard') }}" class="px-6 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium shadow-sm hover:shadow">
                    Cancel
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg font-semibold hover:from-green-700 hover:to-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                >
                    Process Payment & Generate Receipt
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function billingForm() {
    return {
        studentId: '{{ $selectedStudentId ?? '' }}',
        selectedStudentName: '{{ isset($selectedStudentId) && $students->firstWhere("id", $selectedStudentId) ? $students->firstWhere("id", $selectedStudentId)->full_name . " (" . $students->firstWhere("id", $selectedStudentId)->student_number . ")" : "" }}',
        classId: '',
        agreedAmount: '',
        amountPaid: '',
        classInfo: null,
        studentClasses: [],
        selectedTerm: '{{ $currentTerm }}',
        
        init() {
            // Ensure current term is selected by default
            const termSelect = document.getElementById('term');
            if (termSelect && !this.selectedTerm) {
                const currentTermOption = termSelect.querySelector('option[selected]');
                if (currentTermOption) {
                    this.selectedTerm = currentTermOption.value;
                }
            }
            
            // If student is pre-selected, trigger any necessary actions
            if (this.studentId) {
                this.loadStudentInfo();
            }
        },
        
        async loadStudentInfo() {
            if (!this.studentId) {
                this.studentClasses = [];
                this.classId = '';
                this.classInfo = null;
                this.selectedStudentName = '';
                // Show all classes when no student is selected
                this.$nextTick(() => {
                    const select = this.$refs.classSelect;
                    if (select) {
                        Array.from(select.options).forEach(option => {
                            if (option.value !== '') {
                                option.style.display = '';
                            }
                        });
                    }
                });
                return;
            }
            
            // Get selected term for filtering
            const termSelect = document.getElementById('term');
            const selectedTerm = termSelect ? termSelect.value : null;
            
            try {
                const url = `/billing/student/${this.studentId}/classes${selectedTerm ? '?term=' + encodeURIComponent(selectedTerm) : ''}`;
                const response = await fetch(url);
                const classes = await response.json();
                this.studentClasses = classes;
                
                // Reset class selection when student changes
                this.classId = '';
                this.classInfo = null;
                this.agreedAmount = '';
                this.amountPaid = '';
                
                // Show all classes (students can pay for any class in any term)
                // But we'll keep the studentClasses array for reference
                this.$nextTick(() => {
                    const select = this.$refs.classSelect;
                    if (select) {
                        // Show all classes - students can pay for any class in any term
                        Array.from(select.options).forEach(option => {
                            if (option.value !== '') {
                                option.style.display = '';
                            }
                        });
                    }
                });
            } catch (error) {
                console.error('Error loading student classes:', error);
                this.studentClasses = [];
            }
        },
        
        async loadTermClasses() {
            // Reload classes when term changes
            if (this.studentId) {
                await this.loadStudentInfo();
            }
        },
        
        async loadClassInfo() {
            if (!this.classId) {
                this.classInfo = null;
                return;
            }
            
            try {
                const response = await fetch(`/billing/class/${this.classId}`);
                const data = await response.json();
                this.classInfo = data;
                
                // Auto-fill agreed amount with class price if available (for Super Admin)
                @if(auth()->user()->isSuperAdmin())
                if (data.price && !this.agreedAmount) {
                    this.agreedAmount = parseFloat(data.price);
                    this.syncAmountPaid();
                }
                @endif
            } catch (error) {
                console.error('Error loading class info:', error);
            }
        },
        
        syncAmountPaid() {
            // Automatically sync amount paid with agreed amount (no discounts)
            const agreed = parseFloat(this.agreedAmount) || 0;
            this.amountPaid = agreed;
        },
        
        submitForm() {
            // Ensure amount paid equals agreed amount (no discounts)
            if (this.agreedAmount) {
                this.amountPaid = parseFloat(this.agreedAmount) || 0;
            }
            // Form validation happens on server side
            this.$el.submit();
        }
    }
}
</script>
@endsection

