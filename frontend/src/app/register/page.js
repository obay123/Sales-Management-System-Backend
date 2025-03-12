"use client";

import { useState } from "react";
import useUserApi from "@/api/UserApi";

export default function Register() {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const { register } = useUserApi();

    const Register = async (e) => {
      e.preventDefault();
      try {
        const data = await register(name, email, password);
        console.log("Registration successfull", data);
      } catch (error) {
        console.error("Registration failed", error);
      }
    };

  return (
    <div className="main-div">
      <h2>
        <input
          type="text"
          placeholder="Name"
          value={name}
          onChange={(e) => setName(e.target.value)}
        />

        <input
          type="text"
          placeholder="Email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
        />

        <input
          type="password"
          placeholder="Password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
        />

        <button onClick={Register}>Register</button>
      </h2>
    </div>
  );
}
