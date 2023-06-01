@extends('layouts.app')
@section('content')
<!-- Contact page -->

<!-- Title and subtitle -->
<div class="titles text-center text-white font-bold pb-5">
    <h1 class="title lg:text-6xl text-4xl mb-5 pt-10">Contact</h1>
</div>

<div class="flex justify-center ml-10 mr-10">

    <form class="w-full max-w-lg">

        <div class="flex flex-wrap -mx-3 mb-6">

            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-white text-xs font-bold mb-2" for="grid-first-name">
                    Prénom
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-white border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text" placeholder="Joao">
                <p class="text-red-500 text-xs italic">Veuillez remplir ce champ.</p>
            </div>

            <div class="w-full md:w-1/2 px-3">
                <label class="block uppercase tracking-wide text-white text-xs font-bold mb-2" for="grid-last-name">
                    Nom
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Ferreira">
            </div>

        </div>

        <div class="flex flex-wrap -mx-3 mb-6">

            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-white text-xs font-bold mb-2" for="grid-password">
                    E-mail
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="email" type="email">
            </div>

        </div>

        <div class="flex flex-wrap -mx-3 mb-6">

            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-white text-xs font-bold mb-2" for="grid-password">
                    Message
                </label>
                <textarea class=" no-resize appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 h-48 resize-none" id="message"></textarea>
            </div>

        </div>

        <div class="md:flex md:items-center justify-center mb-10">

            <div class="md:w-1/3 flex text-center">
                <button class="shadow bg-gray-400 hover:bg-[#134563] focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="button">
                    Envoyer
                </button>
            </div>

            <div class="md:w-2/3"></div>

        </div>
    </form>
</div>

<!-- Form from : https://tailwindcomponents.com/component/basic-contact-form -->
@endsection