"use client";

import React from "react";
import {
  FaCar,
  FaCarAlt,
  FaCarCrash,
  FaCarBattery,
  FaCarSide,
} from "react-icons/fa";
// import { SiTailwindcss, SiNextdotjs } from 'react-icons/si'

// about data
const about = {
  title: "About",
  description: "Lorem ipsum dolor sit amet consectetur adipisicing elit.",
  info: [
    {
      fieldName: "Brand",
      fieldValue: "Nissan",
    },
    {
      fieldName: "Model",
      fieldValue: "Skyline R34 GT-R",
    },
    {
      fieldName: "Description",
      fieldValue: "Best car in my opinion.",
    },
    {
      fieldName: "Horsepower",
      fieldValue: "276 HP",
    },
    {
      fieldName: "Top Speed",
      fieldValue: "165 MPH",
    },
    {
      fieldName: "Engine",
      fieldValue: "2.6 Liter Inline-Six Turbocharged",
    },
    {
      fieldName: "Use Price",
      fieldValue: "₱1,379,809.25 - ₱12,905,846.55",
    },
    {
      fieldName: "Driveline",
      fieldValue: "Front Wheel Drive",
    },
  ],
};

// experience
const brand = {
  icon: "/assets/resume/badge.svg",
  title: "Brand and Model",
  description: "Lorem ipsum dolor sit amet consectetur adipisicing elit.",
  items: [
    {
      brand: "Nissan",
      model: "Skyline R34 GT-R",
      year: "2001",
    },
    {
      brand: "Nissan",
      model: "Skyline R34 GT-R",
      year: "2001",
    },
    {
      brand: "Nissan",
      model: "Skyline R34 GT-R",
      year: "2001",
    },
    {
      brand: "Nissan",
      model: "Skyline R34 GT-R",
      year: "2001",
    },
    {
      brand: "Nissan",
      model: "Skyline R34 GT-R",
      year: "2001",
    },
    {
      brand: "Nissan",
      model: "Skyline R34 GT-R",
      year: "2001",
    },
  ],
};

// education data
const speed = {
  icon: "/assets/resume/cap.svg",
  title: "Top Speed of the Year",
  description: "Lorem ipsum dolor sit amet consectetur adipisicing elit.",
  items: [
    {
      brand: "McLaren",
      model: "McLaren 720S Orange",
      year: "2024",
    },
    {
      brand: "McLaren",
      model: "McLaren 720S Orange",
      year: "2024",
    },
    {
      brand: "McLaren",
      model: "McLaren 720S Orange",
      year: "2024",
    },
    {
      brand: "McLaren",
      model: "McLaren 720S Orange",
      year: "2024",
    },
    {
      brand: "McLaren",
      model: "McLaren 720S Orange",
      year: "2024",
    },
    {
      brand: "McLaren",
      model: "McLaren 720S Orange",
      year: "2024",
    },
  ],
};

// skills
const engine = {
  title: "Engine and Fixsomething :>",
  description: "Lorem ipsum dolor sit amet consectetur adipisicing elit.",
  engineList: [
    {
      icon: <FaCar />,
      name: "Car",
    },
    {
      icon: <FaCarAlt />,
      name: "Car Alt",
    },
    {
      icon: <FaCarBattery />,
      name: "Car Battery",
    },
    {
      icon: <FaCarCrash />,
      name: "Car Crash",
    },
    {
      icon: <FaCarSide />,
      name: "Car Side",
    },
  ],
};

import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";

import {
  Tooltip,
  TooltipContent,
  TooltipProvider,
  TooltipTrigger,
} from "@/components/ui/tooltip";

import { ScrollArea } from "@/components/ui/scroll-area";
import { motion } from "framer-motion";
import Header from "@/components/Header";

const CarFile = () => {
  return (
    <>
      <Header />
      <motion.div
        initial={{ opacity: 0 }}
        animate={{
          opacity: 1,
          transition: { delay: 2.4, duration: 0.4, ease: "easeIn" },
        }}
        className="min-h-[80vh] flex items-center justify-center py-12 xl:py-0"
      >
        <div className="container mx-auto">
          <Tabs
            defaultValue="brand"
            className="flex flex-col xl:flex-row gap-[60px]"
          >
            <TabsList className="flex flex-col w-full max-w-[380px] mx-auto xl:mx-0 gap-6">
              <TabsTrigger value="brand">Brand</TabsTrigger>
              <TabsTrigger value="speed">Top Speed</TabsTrigger>
              <TabsTrigger value="engine">Engine</TabsTrigger>
              <TabsTrigger value="about">About</TabsTrigger>
            </TabsList>

            {/* content */}
            <div className="min-h-[70vh] w-full">
              {/* brand */}
              <TabsContent value="brand" className="w-full">
                <div className="flex flex-col gap-[30px] text-center xl:text-left">
                  <h3 className="text-4xl font-bold">{brand.title}</h3>
                  <p className="max-w-[600px] text-white/60 mx-auto xl:mx-0">
                    {brand.description}
                  </p>
                  <ScrollArea className="h-[400px]">
                    <ul className="grid grid-cols-1 lg:grid-cols-2 gap-[30px]">
                      {brand.items.map((item, index) => {
                        return (
                          <li
                            key={index}
                            className="bg-[#232329] h-[184px] py-6 px-10 rounded-xl flex flex-col
                      justify-center items-center lg:items-start gap-1"
                          >
                            <span className="text-accent">{item.year}</span>
                            <h3 className="text-xl max-w-[260px] min-h-[60px] text-center lg:text-left">
                              {item.model}
                            </h3>
                            <div className="flex items-center gap-3">
                              {/* dot */}
                              <span className="w-[6px] h-[6px] rounded-full bg-accent"></span>
                              <p className="text-white/60">{item.brand}</p>
                            </div>
                          </li>
                        );
                      })}
                    </ul>
                  </ScrollArea>
                </div>
              </TabsContent>

              {/* top speed */}
              <TabsContent value="speed" className="w-full">
                <div className="flex flex-col gap-[30px] text-center xl:text-left">
                  <h3 className="text-4xl font-bold">{speed.title}</h3>
                  <p className="max-w-[600px] text-white/60 mx-auto xl:mx-0">
                    {speed.description}
                  </p>
                  <ScrollArea className="h-[400px]">
                    <ul className="grid grid-cols-1 lg:grid-cols-2 gap-[30px]">
                      {speed.items.map((item, index) => {
                        return (
                          <li
                            key={index}
                            className="bg-[#232329] h-[184px] py-6 px-10 rounded-xl flex flex-col
                      justify-center items-center lg:items-start gap-1"
                          >
                            <span className="text-accent">{item.year}</span>
                            <h3 className="text-xl max-w-[260px] min-h-[60px] text-center lg:text-left">
                              {item.model}
                            </h3>
                            <div className="flex items-center gap-3">
                              {/* dot */}
                              <span className="w-[6px] h-[6px] rounded-full bg-accent"></span>
                              <p className="text-white/60">
                                {item.brand}
                              </p>
                            </div>
                          </li>
                        );
                      })}
                    </ul>
                  </ScrollArea>
                </div>
              </TabsContent>

              {/* engine */}
              <TabsContent value="engine" className="w-full h-full">
                <div className="flex flex-col gap-[30px]">
                  <div className="flex flex-col gap-[30px] text-center xl:text-left">
                    <h3 className="text-4xl font-bold">{engine.title}</h3>
                    <p className="max-w-[600px] text-white/60 mx-auto xl:mx-0">
                      {engine.description}
                    </p>
                  </div>
                  <ul className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 xl:gap-[30px]">
                    {engine.engineList.map((skill, index) => {
                      return (
                        <li key={index}>
                          <TooltipProvider delayDuration={100}>
                            <Tooltip>
                              <TooltipTrigger className="w-full h-[150px] bg-[#232329] rounded-xl flex justify-center items-center group">
                                <div className="text-6xl group-hover:text-accent transition-all duration-300">
                                  {skill.icon}
                                </div>
                              </TooltipTrigger>
                              <TooltipContent>
                                <p className="capitalize">{skill.name}</p>
                              </TooltipContent>
                            </Tooltip>
                          </TooltipProvider>
                        </li>
                      );
                    })}
                  </ul>
                </div>
              </TabsContent>

              {/* about */}
              <TabsContent
                value="about"
                className="w-full text-center xl:text-left"
              >
                <div className="flex flex-col gap-[30px]">
                  <h3 className="text-4xl font-bold">{about.title}</h3>
                  <p className="max-w-[600px] text-white/60 mx-auto xl:mx-0">
                    {about.description}
                  </p>
                  <ul className="grid grid-cols-1 xl:grid-cols-2 gap-y-6 max-w-[620px] mx-auto xl:mx-0">
                    {about.info.map((item, index) => {
                      return (
                        <li
                          key={index}
                          className="flex items-center justify-center xl:justify-start gap-4"
                        >
                          <span className="text-white/60">
                            {item.fieldName}
                          </span>
                          <span className="text-xl">{item.fieldValue}</span>
                        </li>
                      );
                    })}
                  </ul>
                </div>
              </TabsContent>
            </div>
          </Tabs>
        </div>
      </motion.div>
    </>
  );
};

export default CarFile;
