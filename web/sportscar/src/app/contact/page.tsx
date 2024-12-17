"use client";
import React from "react";
import Header from "@/components/Header";
import { Button } from "@/components/ui/button";

const Contact = () => {
  const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    // Handle form submission logic here
  };

  return (
    <>
      <Header />
      <div className="min-h-screen bg-primary flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div className="max-w-md w-full space-y-8 bg-secondary p-8 rounded-lg shadow-lg border-2 border-accent">
          <div>
            <h2 className="text-3xl font-bold text-center text-white mb-8">Contact Us</h2>
            <p className="text-white/60 text-center mb-8">
              Have questions? We&apos;d love to hear from you.
            </p>
          </div>

          <form onSubmit={handleSubmit} className="space-y-6">
            <div>
              <label htmlFor="name" className="block text-sm text-gray-400">
                Name
              </label>
              <input
                type="text"
                id="name"
                required
                className="w-full p-3 rounded bg-[#2A2A2A] text-white border border-gray-600 focus:border-accent focus:outline-none"
                placeholder="Your name"
              />
            </div>

            <div>
              <label htmlFor="email" className="block text-sm text-gray-400">
                Email
              </label>
              <input
                type="email"
                id="email"
                required
                className="w-full p-3 rounded bg-[#2A2A2A] text-white border border-gray-600 focus:border-accent focus:outline-none"
                placeholder="your@email.com"
              />
            </div>

            <div>
              <label htmlFor="message" className="block text-sm text-gray-400">
                Message
              </label>
              <textarea
                id="message"
                required
                rows={4}
                className="w-full p-3 rounded bg-[#2A2A2A] text-white border border-gray-600 focus:border-accent focus:outline-none"
                placeholder="Your message"
              />
            </div>

            <Button
              type="submit"
              className="w-full bg-accent text-white hover:bg-accent/90 transition-colors py-3"
            >
              Send Message
            </Button>
          </form>
        </div>
      </div>
    </>
  );
};

export default Contact;
