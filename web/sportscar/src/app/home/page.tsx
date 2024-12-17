"use client";
import Social from "@/components/Social";
import { Button } from "@/components/ui/button";
import { FiArrowDownCircle } from "react-icons/fi";
import React, { useEffect, useState } from "react";
import Photo from "@/components/Photo";
import Stats from "@/components/Stats";
import Header from "@/components/Header";

const Home = () => {
  const [userName, setUserName] = useState<string | null>(null);

  useEffect(() => {
    const user = JSON.parse(localStorage.getItem("user") || "{}");
    if (user && user.firstName) {
      setUserName(user.firstName);
    }
  }, []);

  return (
    <>
      <Header />
      <section className="h-full">
        <div className="container mx-auto h-full">
          <div className="flex flex-col xl:flex-row items-center justify-between xl:pt-8 xl:pb-24">
            {/* text */}
            <div className="text-center xl:text-left order-2 xl:order-none">
              <span className="text-center xl:text-left">
                Sports Car Dealership
              </span>
              <h1 className="h1 mb-6 capitalize">
                Welcome, {userName ? userName : "Guest"}
                <br />
                <span className="text-accent">Ride Own</span>
              </h1>
              <p className="max-w-[500px] mb-9 text-white/80">
              Exotic Car is a comprehensive platform designed for both the purchase and rental of high-performance sports cars. It provides users with an extensive inventory of luxury vehicles, detailed specifications, and high-quality visuals. Whether you&apos;re looking to own your dream car or rent one for a special occasion, Exotic Car offers a seamless, reliable, and premium experience tailored to meet the needs of car enthusiasts and professionals alike.
              </p>

              <div className="flex flex-col xl:flex-row items-center gap-8">
                <Button
                  variant="outline"
                  size="lg"
                  className="uppercase flex items-center gap-2"
                >
                  Show More
                  <FiArrowDownCircle className="tex-xl" />
                </Button>

                <div className="mb-8 xl:mb-0">
                  <Social
                    containerStyles="flex gap-6"
                    iconStyles="w-9 h-9 border border-accent rounded-full flex justify-center items-center text-accent text-base hover:bg-accent hover:text-primary hover:transition-all duration-500 "
                  />
                </div>
              </div>
            </div>
            {/* photo */}
            <div className="order-1 xl:order-none mb-8 xl:mb-0">
              <Photo />
            </div>
          </div>
        </div>
        <Stats />
      </section>
    </>
  );
};

export default Home;
