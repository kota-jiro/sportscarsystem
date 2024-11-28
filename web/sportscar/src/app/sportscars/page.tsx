"use client";
import React, { useState } from "react";
import { motion } from "framer-motion";
import Link from "next/link";

import Image from "next/image";
import image1 from "@/images/Nissan_Skyline_R34_GT-R_Nür_001.jpg";
import image2 from "@/images/2015_Porsche_911_Carrera_4S_Coupe.jpg";
import image3 from "@/images/McLaren_720S_Orange.jpg";

import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";

import { BsArrowUpRight, BsCarFrontFill, BsCarFront } from "react-icons/bs";

import {
  Tooltip,
  TooltipContent,
  TooltipProvider,
  TooltipTrigger,
} from "@/components/ui/tooltip";
import Header from "@/components/Header";

const sportscar = [
  {
    num: "01",
    brand: "Nissan",
    model: "Skyline R34 GT-R",
    description:
      "The Nissan Skyline R34 GT-R has a 2.6L twin-turbo inline-six with 276 hp, a 0-100 km/h time of 4.9 seconds, and a top speed of 250 km/h.",
    stack: [{ name: "AWD" }, { name: "Car" }, { name: "Car" }],
    image: image1,
    live: "",
    car: "",
  },
  {
    num: "02",
    brand: "Porsche",
    model: "911 Carrera",
    description:
      "The Porsche 911 Carrera has a 3.0L twin-turbo flat-six engine with 379 hp. It accelerates from 0 to 100 km/h in 4.2 seconds and has a top speed of 293 km/h.",
    stack: [{ name: "AWD" }, { name: "Car" }, { name: "Car" }],
    image: image2,
    live: "",
    car: "",
  },
  {
    num: "03",
    brand: "McLaren",
    model: "720S",
    description:
      "The McLaren 720S has a 4.0L twin-turbo V8 engine with 720 hp. It goes from 0 to 100 km/h in 2.9 seconds and has a top speed of 341 km/h.",
    stack: [{ name: "RWD" }, { name: "Car" }, { name: "Car" }],
    image: image3,
    live: "",
    car: "",
  },
];

const SportsCars = () => {
  const [car, setCar] = useState(sportscar[0]);

  const handleSlideChange = (swiper) => {
    // get current slide index
    const currentIndex = swiper.activeIndex;
    // update car state based on  current slide index
    setCar(sportscar[currentIndex]);
  };

  return (
    <>
      <Header />
      <motion.section
        initial={{ opacity: 0 }}
        animate={{
          opacity: 1,
          transition: { delay: 2.4, duration: 0.4, ease: "easeIn" },
        }}
        className="min-h-[80vh] flex flex-col justify-center py-12 xl:py-0"
      >
        <div className="container mx-auto">
          <div className="flex flex-col xl:flex-row xl:gap-[30px]">
            <div className="w-full xl:w-[50%] xl:h-[460px] flex flex-col xl:justify-between order-2 xl:order-none">
              <div className="flex flex-col gap-[30px] h-[50%]">
                {/* outline num */}
                <div className="text-8xl leading-none font-extrabold text-transparent text-outline">
                  {car.num}
                </div>
                {/* sports car brand */}
                <h2 className="text-[42px] font-bold leading-none text-white group-hover:text-accent transition-all duration-500 capitalize">
                  {car.brand} car
                </h2>
                {/* sport car description */}
                <p className="text-white/60">{car.description}</p>
                {/* stack */}
                <ul className="flex gap-4">
                  {car.stack.map((item, index) => {
                    return (
                      <li key={index} className="text-xl text-accent">
                        {item.name}
                        {/* remove the last comma */}
                        {index !== car.stack.length - 1 && ","}
                      </li>
                    );
                  })}
                </ul>
                {/* border */}
                <div className="border border-white/20"></div>
                {/* buttons */}
                <div className="flex items-center gap-4">
                  {/* live car button */}
                  <Link href={car.live}>
                    <TooltipProvider delayDuration={100}>
                      <Tooltip>
                        <TooltipTrigger className="w-[70px] h-[70px] rounded-full bg-white/5 flex justify-center items-center group">
                          <BsArrowUpRight className="text-white text-3xl group-hover:text-accent" />
                        </TooltipTrigger>
                        <TooltipContent>
                          <p>Live car</p>
                        </TooltipContent>
                      </Tooltip>
                    </TooltipProvider>
                  </Link>
                  {/* car car button */}
                  <Link href={car.car}>
                    <TooltipProvider delayDuration={100}>
                      <Tooltip>
                        <TooltipTrigger className="w-[70px] h-[70px] rounded-full bg-white/5 flex justify-center items-center group">
                          <BsCarFront className="text-white text-3xl group-hover:text-accent" />
                          <BsCarFrontFill className="text-white text-3xl group-hover:text-accent" />
                        </TooltipTrigger>
                        <TooltipContent>
                          <p>Sports Car</p>
                        </TooltipContent>
                      </Tooltip>
                    </TooltipProvider>
                  </Link>
                </div>
              </div>
            </div>
            <div className="w-full xl:w-[50%]">
              <Swiper
                spaceBetween={30}
                slidesPerView={1}
                className="xl:h-[520px] mb-12"
                onSlideChange={handleSlideChange}
              >
                {sportscar.map((car, index) => {
                  return (
                    <SwiperSlide key={index} className="w-full">
                      <div className="h-[460px] relative group flex justify-center items-center bg-pink-50/20">
                        {/* overlay */}
                        <div className="absolute top-0 bottom-0 w-full h-full bg-black/10 z-10"></div>
                        {/* image */}
                        <div className="relative w-[100%] h-[66%]">
                          <Image
                            src={car.image}
                            fill
                            className="object-cover"
                            alt=""
                          />
                        </div>
                      </div>
                    </SwiperSlide>
                  );
                })}
              </Swiper>
            </div>
          </div>
        </div>
      </motion.section>
    </>
  );
};

export default SportsCars;
