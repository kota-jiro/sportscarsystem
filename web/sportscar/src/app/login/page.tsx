"use client";
import React, { useState, useEffect } from "react";
import Image from "next/image";
import { useRouter } from "next/navigation";
import { Button } from "@/components/ui/button";

interface LoginResponse {
  user?: {
    userId: string;
    firstName: string;
    lastName: string;
    phone: string;
    address: string;
    username: string;
    password: string;
    image: string;
    roleId: number;
  };
  error?: string;
}

const Login = () => {
  const [username, setUsername] = useState<string>("");
  const [password, setPassword] = useState<string>("");
  const [error, setError] = useState<string | null>(null);
  const [successMessage, setSuccessMessage] = useState<string | null>(null);
  const router = useRouter();

  useEffect(() => {
    // Check URL parameters for registration success
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('registered') === 'true') {
      setSuccessMessage('Registered successfully! Please login');
      
      // Clear the URL parameter
      const newUrl = window.location.pathname;
      window.history.replaceState({}, '', newUrl);
      
      // Auto-hide the success message after 5 seconds
      const timer = setTimeout(() => {
        setSuccessMessage(null);
      }, 5000);

      // Cleanup timer on component unmount
      return () => clearTimeout(timer);
    }
  }, []);

  const handleLogin = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setError(null);

    try {
      console.log('Attempting login with:', { username, password }); // Debug log

      const loginResponse = await fetch("http://localhost:8000/api/user/login", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
        },
        body: JSON.stringify({ 
          username, 
          password 
        }),
      });

      const data = await loginResponse.json();
      console.log('Login response:', data); // Debug log

      // Check if the response contains an error message
      if (!loginResponse.ok) {
        throw new Error(data.error || data.message || "Invalid username or password");
      }

      // Check if we have user data
      if (!data.user) {
        throw new Error("No user data received");
      }

      const userData = {
        userId: data.user.userId,
        firstName: data.user.firstName,
        lastName: data.user.lastName,
        phone: data.user.phone,
        address: data.user.address,
        username: data.user.username,
        image: data.user.image,
        roleId: data.user.roleId
      };
      
      localStorage.setItem("user", JSON.stringify(userData));
      router.push("/home");
    } catch (error: any) {
      setError(error.message || "Login failed");
      console.error("Login error:", error);
    }
  };

  return (
    <div className="flex items-center justify-center min-h-screen bg-primary px-4">
      <div className="w-full max-w-md border border-accent rounded-lg shadow-lg p-6 space-y-6">
        {/* Add success message display */}
        {successMessage && (
          <div className="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {successMessage}
          </div>
        )}
        {/* Centered Logo */}
        <div className="flex justify-center">
          <Image
            src="/logo.png" // Make sure to add your logo image
            alt="Logo"
            width={80}
            height={80}
            className="rounded-full"
          />
        </div>
        {/* Form Title */}
        <h2 className="text-3xl font-semibold text-center">Exotic Car</h2>
        {/* Login Form */}
        <form onSubmit={handleLogin} className="space-y-4">
          {error && (
            <div className="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
              {error}
            </div>
          )}
          {/* Username Input */}
          <div className="form-control">
            <label htmlFor="username" className="label">
              <span className="label-text">Username</span>
            </label>
            <input
              id="username"
              type="text"
              placeholder="Enter your username"
              className="input input-bordered w-full py-1 px-2 bg-gray-50 text-gray-800"
              value={username}
              onChange={(e) => setUsername(e.target.value)}
              required
            />
          </div>
          {/* Password Input */}
          <div className="form-control">
            <label htmlFor="password" className="label">
              <span className="label-text">Password</span>
            </label>
            <input
              id="password"
              type="password"
              placeholder="Enter your password"
              className="input input-bordered w-full py-1 px-2 bg-gray-50 text-gray-800"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
            />
          </div>
          {/* Login Button */}
          <Button
            type="submit"
            className="btn btn-primary w-full py-2 rounded-md hover:bg-primary-dark"
          >
            Login
          </Button>
        </form>
        {/* Register Link */}
        <p className="text-center text-sm text-white/60">
          Don&apos;t have an account?{" "}
          <a href="/register" className="text-accent/80 hover:underline">
            Register here
          </a>
        </p>
      </div>
    </div>
  );
};

export default Login;

