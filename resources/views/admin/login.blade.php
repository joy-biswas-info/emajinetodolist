<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="bg-white shadow-md rounded-md mx-auto max-w-sm p-4">
        <div class="text-center">
            <a href="#" class="text-2xl font-semibold">Administrative Panel</a>
        </div>
        <div class="mt-4">
            <p class="text-center text-lg">Sign in to start your session</p>
            <form action="dashboard.html" method="post">
                <div class="mb-4">
                    <div class="relative">
                        <input type="email"
                            class="border rounded-md w-full py-2 px-3 placeholder-gray-400 focus:outline-none focus:ring focus:border-blue-300"
                            placeholder="Email">
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <span class="fas fa-envelope text-gray-400"></span>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="relative">
                        <input type="password"
                            class="border rounded-md w-full py-2 px-3 placeholder-gray-400 focus:outline-none focus:ring focus:border-blue-300"
                            placeholder="Password">
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <span class="fas fa-lock text-gray-400"></span>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" class="form-checkbox h-4 w-4 text-blue-600">
                        <label for="remember" class="ml-2 text-gray-700">Remember Me</label>
                    </div>
                </div>
                <div class="mb-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 w-full rounded-md">Login</button>
                </div>
            </form>
            <p class="text-center text-blue-600 mt-3">
                <a href="forgot-password.html">I forgot my password</a>
            </p>
        </div>
    </div>

</x-guest-layout>
