"use client";
import React, { useState } from "react"
import { motion } from 'framer-motion'
import Link from "next/link";
import Image from "next/image";

import { Swiper, SwiperSlide } from 'swiper/react'
import 'swiper/css'

import { BsArrowUpRight, BsGithub, BsCar, BsCarFrontFill, BsCarFront } from 'react-icons/bs'

import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from "@/components/ui/tooltip";

const sportscar = [
  {
    num: '01',
    brand: 'Nissan',
    model: 'Skyline R34 GT-R',
    description: '',
  }
]

const SportsCars = () => {
  return (
    <div>sportscar page</div>
  )
}

export default SportsCars
