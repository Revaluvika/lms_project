@extends('layouts.app')

@section('title', 'Registrasi Sekolah Baru')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-linear-to-br from-blue-50 to-indigo-50" 
     x-data="{ 
         step: {{ $errors->any() ? ($errors->hasAny(['npsn', 'school_name', 'education_level', 'ownership_status', 'address', 'district', 'village']) ? 2 : ($errors->hasAny(['verification_doc', 'logo']) ? 3 : 1)) : 1 }},
         fileName: '',
         logoName: '',
         nextStep() { if(this.step < 3) this.step++ },
         prevStep() { if(this.step > 1) this.step-- }
     }">
    
    <div class="max-w-4xl w-full space-y-8 bg-white p-10 rounded-2xl shadow-xl transition-all duration-300 ring-1 ring-gray-100">
        
        <!-- Header -->
        <div class="text-center">
            <h2 class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight">
                Registrasi Sekolah Baru
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Bergabunglah dengan platform pendidikan masa depan.
            </p>
        </div>

        @if (session('success'))
            <div class="rounded-md bg-green-50 p-4 border-l-4 border-green-400">
                <div class="flex">
                    <div class="shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Progress Steps -->
        <div class="relative flex justify-between items-center w-full max-w-2xl mx-auto mb-8">
            <div class="absolute bg-gray-200 h-1 w-full top-1/2 transform -translate-y-1/2 z-0 rounded-full"></div>
            
            <!-- Step 1 Indicator -->
            <div class="relative z-10 flex flex-col items-center group cursor-pointer" @click="step >= 1 ? step = 1 : null">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 border-4"
                     :class="step >= 1 ? 'bg-indigo-600 border-indigo-200 text-white shadow-lg scale-110' : 'bg-gray-300 border-gray-100 text-gray-500'">
                    1
                </div>
                <div class="absolute top-12 text-xs font-semibold uppercase tracking-wider whitespace-nowrap"
                     :class="step >= 1 ? 'text-indigo-600' : 'text-gray-400'">
                    Akun Operator
                </div>
            </div>
            
            <!-- Step 2 Indicator -->
            <div class="relative z-10 flex flex-col items-center group cursor-pointer" @click="step >= 2 ? step = 2 : null">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 border-4"
                     :class="step >= 2 ? 'bg-indigo-600 border-indigo-200 text-white shadow-lg scale-110' : 'bg-gray-300 border-gray-100 text-gray-500'">
                    2
                </div>
                <div class="absolute top-12 text-xs font-semibold uppercase tracking-wider whitespace-nowrap"
                     :class="step >= 2 ? 'text-indigo-600' : 'text-gray-400'">
                    Data Sekolah
                </div>
            </div>

            <!-- Step 3 Indicator -->
            <div class="relative z-10 flex flex-col items-center group cursor-pointer" @click="step >= 3 ? step = 3 : null">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 border-4"
                     :class="step >= 3 ? 'bg-indigo-600 border-indigo-200 text-white shadow-lg scale-110' : 'bg-gray-300 border-gray-100 text-gray-500'">
                    3
                </div>
                <div class="absolute top-12 text-xs font-semibold uppercase tracking-wider whitespace-nowrap"
                     :class="step >= 3 ? 'text-indigo-600' : 'text-gray-400'">
                    Verifikasi
                </div>
            </div>
        </div>

        <form action="{{ route('school.register.store') }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-6">
            @csrf

            <!-- Step 1: Akun Operator -->
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-x-4"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 class="space-y-6">
                 
                <div class="bg-indigo-50 border-l-4 border-indigo-500 p-4 rounded-r-md">
                    <div class="flex">
                        <div class="shrink-0">
                            <svg class="h-5 w-5 text-indigo-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-indigo-700">
                                Masukkan data penanggung jawab (Operator Sekolah) yang akan mengelola akun ini.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap Operator</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" name="name" id="name" required minlength="3" value="{{ old('name') }}"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3 px-4 placeholder-gray-400" 
                                placeholder="Cth: Budi Santoso, S.Pd">
                            @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Pribadi / Sekolah</label>
                        <div class="mt-1">
                            <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3 px-4 placeholder-gray-400"
                                placeholder="operator@sekolah.sch.id">
                            @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                        <div class="mt-1">
                            <input type="tel" name="phone_number" id="phone_number" required minlength="10" maxlength="14" value="{{ old('phone_number') }}"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3 px-4 placeholder-gray-400"
                                placeholder="081234567890">
                            @error('phone_number') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1">
                            <input type="password" name="password" id="password" required minlength="8"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3 px-4">
                            @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <div class="mt-1">
                            <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3 px-4">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Identitas Sekolah -->
            <div x-show="step === 2" x-cloak
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-x-4"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 class="space-y-6">

                <div class="bg-indigo-50 border-l-4 border-indigo-500 p-4 rounded-r-md">
                    <div class="flex">
                        <div class="shrink-0">
                            <svg class="h-5 w-5 text-indigo-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-indigo-700">
                                Lengkapi identitas sekolah (Tenant) dengan data yang valid sesuai Dapodik/Kemenag.
                            </p>
                        </div>
                    </div>
                </div>
                 
                 <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="npsn" class="block text-sm font-medium text-gray-700">NPSN (8 Digit)</label>
                        <div class="mt-1">
                            <input type="number" name="npsn" id="npsn" required pattern="\d{8}" maxlength="8" value="{{ old('npsn') }}"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3 px-4 placeholder-gray-400"
                                placeholder="12345678">
                            @error('npsn') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="school_name" class="block text-sm font-medium text-gray-700">Nama Sekolah</label>
                        <div class="mt-1">
                            <input type="text" name="school_name" id="school_name" required value="{{ old('school_name') }}"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3 px-4 placeholder-gray-400"
                                placeholder="SD Negeri 1 Surabaya">
                            @error('school_name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="education_level" class="block text-sm font-medium text-gray-700">Jenjang Pendidikan</label>
                        <div class="mt-1">
                            <select id="education_level" name="education_level" required
                                class="mt-1 block w-full py-3 px-4 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled selected>Pilih Jenjang</option>
                                <option value="SD" {{ old('education_level') == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('education_level') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ old('education_level') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="SMK" {{ old('education_level') == 'SMK' ? 'selected' : '' }}>SMK</option>
                                <option value="SLB" {{ old('education_level') == 'SLB' ? 'selected' : '' }}>SLB</option>
                            </select>
                            @error('education_level') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Status Sekolah</label>
                        <div class="flex items-center space-x-6 mt-2">
                             <div class="flex items-center">
                                <input id="negeri" name="ownership_status" type="radio" value="negeri" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ old('ownership_status') == 'negeri' ? 'checked' : '' }} required>
                                <label for="negeri" class="ml-3 block text-sm font-medium text-gray-700">Negeri</label>
                            </div>
                            <div class="flex items-center">
                                <input id="swasta" name="ownership_status" type="radio" value="swasta" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ old('ownership_status') == 'swasta' ? 'checked' : '' }}>
                                <label for="swasta" class="ml-3 block text-sm font-medium text-gray-700">Swasta</label>
                            </div>
                        </div>
                        @error('ownership_status') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                        <div class="mt-1">
                            <textarea id="address" name="address" rows="3" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md py-3 px-4">{{ old('address') }}</textarea>
                            @error('address') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="district" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                        <div class="mt-1">
                            <input type="text" name="district" id="district" required value="{{ old('district') }}"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3 px-4"
                                placeholder="Nama Kecamatan">
                            @error('district') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="village" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                        <div class="mt-1">
                            <input type="text" name="village" id="village" required value="{{ old('village') }}"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-3 px-4"
                                placeholder="Nama Kelurahan">
                            @error('village') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Verifikasi Legalitas -->
            <div x-show="step === 3" x-cloak
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-x-4"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 class="space-y-6">

                 <div class="bg-indigo-50 border-l-4 border-indigo-500 p-4 rounded-r-md">
                    <div class="flex">
                        <div class="shrink-0">
                            <svg class="h-5 w-5 text-indigo-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-indigo-700">
                                Unggah dokumen legalitas untuk verifikasi oleh Dinas. Pastikan dokumen terbaca jelas.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 gap-x-6">
                    <!-- Verification Doc -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                             Upload Surat Tugas dari Kepala Sekolah (Stempel Basah)
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-indigo-500 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="verification_doc" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Upload dokumen</span>
                                        <input id="verification_doc" name="verification_doc" type="file" class="sr-only" required accept=".pdf,.jpg,.jpeg" @change="fileName = $event.target.files[0].name">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PDF, JPG, JPEG up to 2MB
                                </p>
                                <p class="text-xs font-semibold text-indigo-600 mt-2" x-text="fileName"></p>
                            </div>
                        </div>
                        @error('verification_doc') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Logo Upload -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Logo Sekolah
                        </label>
                         <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-indigo-500 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="logo" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Upload logo</span>
                                        <input id="logo" name="logo" type="file" class="sr-only" required accept=".jpg,.jpeg,.png" @change="logoName = $event.target.files[0].name">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    JPG, PNG up to 2MB
                                </p>
                                <p class="text-xs font-semibold text-indigo-600 mt-2" x-text="logoName"></p>
                            </div>
                        </div>
                        @error('logo') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Footer Navigation -->
             <div class="pt-5 border-t border-gray-200">
                <div class="flex justify-between">
                    <button type="button" x-show="step > 1" @click="prevStep" 
                        class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" x-cloak>
                        Kembali
                    </button>
                    <div x-show="step === 1" class="w-full"></div> <!-- Spacer for step 1 -->

                    <button type="button" x-show="step < 3" @click="nextStep"
                        class="ml-auto inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Lanjut
                    </button>

                    <button type="submit" x-show="step === 3" x-cloak
                        class="ml-auto inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Kirim Pendaftaran
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection
