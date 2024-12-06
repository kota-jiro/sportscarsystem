"use client";
import React, { useState, useEffect } from "react";
import { motion } from "framer-motion";
import Link from "next/link";
import Image from "next/image";
import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";
import { BsArrowUpRight, BsCarFront } from "react-icons/bs";
import {
  Tooltip,
  TooltipContent,
  TooltipProvider,
  TooltipTrigger,
} from "@/components/ui/tooltip";
import Header from "@/components/Header";

interface SportsCar {
  id: string;
  brand: string;
  model: string;
  year: number;
  description: string;
  speed: string;
  drivetrain: string;
  price: number;
  image: string;
}

const SportsCars = () => {
  const [sportsCars, setSportsCars] = useState<SportsCar[]>([]);
  const [currentCar, setCurrentCar] = useState<SportsCar | null>(null);

  useEffect(() => {
    const fetchSportsCars = async () => {
      try {
        const response = await fetch('http://localhost:8000/api/sportsCars');
        const data = await response.json();
        setSportsCars(data.sportsCars);
        if (data.sportsCars.length > 0) {
          setCurrentCar(data.sportsCars[0]);
        }
      } catch (error) {
        console.error('Error fetching sports cars:', error);
      }
    };

    fetchSportsCars();
  }, []);

  const handleSlideChange = (swiper: any) => {
    const currentIndex = swiper.activeIndex;
    setCurrentCar(sportsCars[currentIndex]);
  };

  if (!currentCar) {
    return <div>Loading...</div>;
  }

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
                <div className="text-8xl leading-none font-extrabold text-transparent text-outline">
                  {String(sportsCars.indexOf(currentCar) + 1).padStart(2, '0')}
                </div>
                <h2 className="text-[42px] font-bold leading-none text-white group-hover:text-accent transition-all duration-500 capitalize">
                  {currentCar.brand} {currentCar.model}
                </h2>
                <p className="text-white/60">{currentCar.description}</p>
                <ul className="flex flex-wrap gap-4">
                  <li className="text-xl text-accent">Year: {currentCar.year}</li>
                  <li className="text-xl text-accent">Speed: {currentCar.speed}</li>
                  <li className="text-xl text-accent">Drivetrain: {currentCar.drivetrain}</li>
                  <li className="text-xl text-accent">Price: ${currentCar.price.toLocaleString()}</li>
                </ul>
                <div className="border border-white/20"></div>
                <div className="flex items-center gap-4">
                  <Link href={`/sportscars/${currentCar.id}`}>
                    <TooltipProvider delayDuration={100}>
                      <Tooltip>
                        <TooltipTrigger className="w-[70px] h-[70px] rounded-full bg-white/5 flex justify-center items-center group">
                          <BsArrowUpRight className="text-white text-3xl group-hover:text-accent" />
                        </TooltipTrigger>
                        <TooltipContent>
                          <p>View Details</p>
                        </TooltipContent>
                      </Tooltip>
                    </TooltipProvider>
                  </Link>
                  <Link href={`/order/${currentCar.id}`}>
                    <TooltipProvider delayDuration={100}>
                      <Tooltip>
                        <TooltipTrigger className="w-[70px] h-[70px] rounded-full bg-white/5 flex justify-center items-center group">
                          <BsCarFront className="text-white text-3xl group-hover:text-accent" />
                        </TooltipTrigger>
                        <TooltipContent>
                          <p>Order Now</p>
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
                {sportsCars.map((car, index) => {
                  return (
                    <SwiperSlide key={index} className="w-full">
                      <div className="h-[460px] relative group flex justify-center items-center bg-pink-50/20">
                        <div className="absolute top-0 bottom-0 w-full h-full bg-black/10 z-10"></div>
                        <div className="relative w-[100%] h-[66%]">
                          <Image
                            src={`http://localhost:8000/images/${car.image}`}
                            fill
                            className="object-cover"
                            alt={`${car.brand} ${car.model}`}
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
