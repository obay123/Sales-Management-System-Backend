"use client";

// import { Toaster } from "sonner";

export default function Home() {
  return (
    <div className="flex flex-col items-center justify-center min-h-screen bg-gray-900 text-white">
      {/* <Toaster richColors position="top-right" /> */}

      <h1 className="text-4xl font-bold text-blue-500">
        Tailwind CSS is Working!
      </h1>
      <p className="mt-4 text-lg text-gray-300">
        If you see this styled text, Tailwind is correctly configured.
      </p>
      <button className="mt-6 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition">
        Test Button
      </button>
    </div>
  );
}
