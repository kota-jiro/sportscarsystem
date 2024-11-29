"use client";
import React, { useState } from "react";
import Image from "next/image";
import { useRouter } from "next/navigation";
import { Button } from "@/components/ui/button";
 
const Login = () => {
    const [email, setEmail] = useState<string>("");
    const [password, setPassword] = useState<string>("");
    const router = useRouter();
  
    const handleLogin = (e: React.FormEvent<HTMLFormElement>) => {
      e.preventDefault();
      console.log(email, password);
      router.push("/home");
    };
  return (
    <div className="flex items-center justify-center min-h-screen bg-primary px-4">
      <div className="w-full max-w-md border border-accent rounded-lg shadow-lg p-6 space-y-6">
        {/* Centered Logo */}
        <div className="flex justify-center">
          <Image
            src=""
            alt="Logo"
            width={80}
            height={80}
            className="rounded-full"
          />
        </div>
        {/* Form Title */}
        <h2 className="text-3xl font-semibold text-center ">Exotic Car</h2>
        {/* Login Form */}
        <form onSubmit={handleLogin} className="space-y-4">
          {/* Email Input */}
          <div className="form-control">
            <label htmlFor="email" className="label">
              <span className="label-text ">Username</span>
            </label>
            <input
              id="email"
              type="text"
              placeholder="Enter your username"
              className="input input-bordered w-full py-1 px-2 bg-gray-50 text-gray-800"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
            />
          </div>
          {/* Password Input */}
          <div className="form-control">
            <label htmlFor="password" className="label">
              <span className="label-text ">Password</span>
            </label>
            <input
              id="password"
              type="password"
              placeholder="Enter your password"
              className="input input-bordered w-full py-1 px-2 bg-gray-50 text-gray-800"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
            />
          </div>
          {/* Login Button */}
          <Button
            type="submit"
            className="btn btn-primary w-full py-2 rounded-md"
          >
            Login
          </Button>
        </form>
        {/* Register Link */}
        <p className="text-center text-sm text-white/60">
          Don&apos;t have an account?
          <a href="/register" className="text-accent/80 hover:underline">
            Register here
          </a>
        </p>
      </div>
    </div>
  )
}

export default Login

