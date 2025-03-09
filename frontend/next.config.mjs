/** @type {import('next').NextConfig} */
const nextConfig = {
    async rewrites() {
      return [
        {
          source: "/api/:path*",
          destination: "http://127.0.0.1:8000/api/:path*", // Laravel Backend
        },
      ];
    },
  };
  
  export default nextConfig;
  