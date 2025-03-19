"use client";

import userApi from "@/api/UserApi";
import { useRouter } from "next/navigation";
import { Toaster } from "sonner";

export default function RootLayout({ children }) {
  const router = useRouter();
  const { logout } = userApi();

  const handleLogout = async () => {
    try {
      await logout();
      router.push("/login");
    } catch (error) {
      console.error("Logout failed:", error.message);
    }
  };
  return (
    <html lang="en">
      <body>
        <button onClick={handleLogout} className="cursor-pointer">Logout</button>
        {children}
      </body>
    </html>
  );
}
