"use client";

import React from "react";
import Link from "next/link";
import { BsArrowDownRight } from "react-icons/bs";

const services = [
  {
    num: "01",
    title: "Order Terms",
    description: "Full payment required before delivery • Valid ID required upon delivery • Warranty included • Free maintenance for 1 year • Cancellation policy applies",
    href: "/sportscars",
  },
  {
    num: "02",
    title: "Rental Terms",
    description: "Full payment required before rental period • Valid driver's license required • Insurance coverage included • Fuel must be replaced • Damage charges apply for any vehicle damage",
    href: "/sportscars",
  },
  {
    num: "03",
    title: "Car Parts",
    description: "High-quality OEM and aftermarket parts • Professional installation available • Warranty on all parts • Regular maintenance packages • Emergency part replacement service",
    href: "/sportscars",
  },
  {
    num: "04",
    title: "Car Accessories",
    description: "Premium car accessories • Professional installation • Custom fitting options • Wide range of brands • Quality assurance guaranteed",
    href: "/sportscars",
  },
];

import { motion } from "framer-motion";
import Header from "@/components/Header";

const Services = () => {
  return (
    <>
      <Header />
      <section className="min-h-[80vh] flex flex-col justify-center py-12 xl:py-0">
        <div className="container mx-auto">
          <motion.div
            initial={{ opacity: 0 }}
            animate={{
              opacity: 1,
              transition: { delay: 2.4, duration: 0.4, ease: "easeIn" },
            }}
            className="grid grid-cols-1 md:grid-cols-2 gap-[60px]"
          >
            {services.map((service, index) => {
              return (
                <div
                  key={index}
                  className="flex-1 flex flex-col justify-center gap-6 group"
                >
                  {/* top */}
                  <div className="w-full flex justify-between items-center">
                    <div className="text-5xl font-extrabold text-outline text-transparent group-hover:text-outline-hover">
                      {service.num}
                    </div>
                    <Link
                      href={service.href}
                      className="w-[70px] h-[70px] rounded-full bg-white group-hover:bg-accent
                      transition-all duration-500 flex justify-center items-center hover:-rotate-45"
                    >
                      <BsArrowDownRight className="text-primary text-3xl" />
                    </Link>
                  </div>
                  {/* title */}
                  <h2 className="text-[42px] font-bold leading-none text-white group-hover:text-accent transition-all duration-500">
                    {service.title}
                  </h2>
                  {/* description */}
                  <p className="text-white/60">{service.description}</p>
                  {/* border */}
                  <div className="border-b border-white/20 w-full"></div>
                </div>
              );
            })}
          </motion.div>
        </div>
      </section>
    </>
  );
};

export default Services;
