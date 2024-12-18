"use client";
import React, { useState, useEffect } from "react";
import { motion } from "framer-motion";
import Link from "next/link";
import Image from "next/image";
import { ScrollArea } from "@/components/ui/scroll-area";
import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";
import { BsArrowUpRight, BsCarFront, BsCalendarCheck } from "react-icons/bs";
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
  const [orderFormData, setOrderFormData] = useState({
    userId: "",
    phone: "",
    address: "",
    paymentMethod: "COD",
  });
  const [isDialogOpen, setIsDialogOpen] = useState(false);
  const [orderStatus, setOrderStatus] = useState<{
    message: string;
    type: "success" | "error";
  } | null>(null);
  const [isRentDialogOpen, setIsRentDialogOpen] = useState(false);
  const [rentFormData, setRentFormData] = useState({
    duration: "day",
    startDate: "",
  });
  const [rentPrice, setRentPrice] = useState(0);
  const [updateMessage, setUpdateMessage] = useState<{
    type: "success" | "error";
    text: string;
  } | null>(null);
  const [selectedBrand, setSelectedBrand] = useState("");

  useEffect(() => {
    const fetchSportsCars = async () => {
      try {
        const response = await fetch("http://localhost:8000/api/sportsCars");
        const data = await response.json();
        setSportsCars(data.sportsCars);
        if (data.sportsCars.length > 0) {
          setCurrentCar(data.sportsCars[0]);
        }
      } catch (error) {
        console.error("Error fetching sports cars:", error);
      }
    };

    fetchSportsCars();
  }, []);

  const handleSlideChange = (swiper: any) => {
    const currentIndex = swiper.activeIndex;
    setCurrentCar(sportsCars[currentIndex]);
  };

  const handleInputChange = (
    e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>
  ) => {
    const { name, value } = e.target;
    setOrderFormData((prev) => ({
      ...prev,
      [name]: value,
    }));
  };

  const handleOrderSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!currentCar) return;

    const user = JSON.parse(localStorage.getItem("user") || "{}");

    const orderData = {
      sportsCarId: currentCar.id,
      name: `${user.firstName} ${user.lastName}`,
      brandModel: `${currentCar.brand} ${currentCar.model}`,
      phone: user.phone,
      address: user.address,
      price: currentCar.price,
      ...orderFormData,
    };

    try {
      const response = await fetch("http://localhost:8000/api/createOrder", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(orderData),
      });

      if (!response.ok) {
        throw new Error("Failed to create order");
      }

      const result = await response.json();
      setOrderStatus({
        message: "Order created successfully!",
        type: "success",
      });
      setIsDialogOpen(false);
      setOrderFormData({
        phone: "",
        address: "",
        paymentMethod: "COD",
      });
    } catch (error) {
      setOrderStatus({
        message: "Failed to create order. Please try again.",
        type: "error",
      });
    }
  };

  const calculateRentPrice = (carPrice: number, duration: string) => {
    if (carPrice <= 100000) {
      return (
        {
          day: 2000,
          week: 12000,
          month: 30000,
        }[duration] || 0
      );
    } else if (carPrice <= 500000) {
      return (
        {
          day: 12000,
          week: 50000,
          month: 120000,
        }[duration] || 0
      );
    } else if (carPrice <= 800000) {
      return (
        {
          day: 23000,
          week: 155000,
          month: 380000,
        }[duration] || 0
      );
    } else {
      return (
        {
          day: 30000,
          week: 180000,
          month: 480000,
        }[duration] || 0
      );
    }
  };

  const handleRentSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!currentCar || !user) return;

    try {
      const response = await fetch("http://localhost:8000/api/rent/create", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          sportsCarId: currentCar.sportsCarId,
          userId: user.userId,
          name: `${user.firstName} ${user.lastName}`,
          phone: user.phone,
          address: user.address,
          brandModel: `${currentCar.brand} ${currentCar.model}`,
          carPrice: currentCar.price,
          duration: rentFormData.duration,
          startDate: rentFormData.startDate,
        }),
      });

      if (response.status === 422) {
        const errorData = await response.json();
        console.error("Validation Errors:", errorData);
        alert("Please correct the form errors.");
        return;
      }

      if (!response.ok) {
        throw new Error(data.message || "Failed to submit rent request");
      }

      setUpdateMessage({
        type: "success",
        text: "Rent request submitted successfully! Please wait for approval.",
      });
      setIsRentDialogOpen(false);
    } catch (error: any) {
      setUpdateMessage({
        type: "error",
        text: error.message || "Failed to submit rent request",
      });
    }
  };

  useEffect(() => {
    if (currentCar && rentFormData.duration) {
      const price = calculateRentPrice(currentCar.price, rentFormData.duration);
      setRentPrice(price);
    }
  }, [currentCar, rentFormData.duration]);

  useEffect(() => {
    if (updateMessage) {
      const timer = setTimeout(() => {
        setUpdateMessage(null);
      }, 3000);
      return () => clearTimeout(timer);
    }
  }, [updateMessage]);

  if (!currentCar) {
    return <div>Loading...</div>;
  }

  const user = JSON.parse(localStorage.getItem("user") || "{}");

  const handleRentClick = (car: any) => {
    setCurrentCar(car);
    setIsRentDialogOpen(true);
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
                <div className="text-8xl leading-none font-extrabold text-transparent text-outline">
                  {String(sportsCars.indexOf(currentCar) + 1).padStart(2, "0")}
                </div>
                <h2 className="text-[42px] font-bold capitalize leading-none text-white group-hover:text-accent transition-all duration-500">
                  {currentCar.brand} {currentCar.model}
                </h2>
                <p className="text-white/60 capitalize">
                  {currentCar.description}
                </p>
                <ul className="flex flex-wrap gap-4">
                  <li className="text-xl text-accent">
                    Year: {currentCar.year}
                  </li>
                  <li className="text-xl text-accent">
                    Speed: {currentCar.speed.toUpperCase()}
                  </li>
                  <li className="text-xl text-accent">
                    Drivetrain: {currentCar.drivetrain.toUpperCase()}
                  </li>
                  <li className="text-xl text-accent">
                    Price: ₱{currentCar.price.toLocaleString()}
                  </li>
                </ul>
                <div className="border border-white/20"></div>
                <div className="flex items-center gap-4">
                  <Link href={`/sportsCars/${currentCar.id}`}>
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
                  <button onClick={() => setIsDialogOpen(true)}>
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
                  </button>
                  <button onClick={() => handleRentClick(currentCar)}>
                    <TooltipProvider delayDuration={100}>
                      <Tooltip>
                        <TooltipTrigger className="w-[70px] h-[70px] rounded-full bg-white/5 flex justify-center items-center group">
                          <BsCalendarCheck className="text-white text-3xl group-hover:text-accent" />
                        </TooltipTrigger>
                        <TooltipContent>
                          <p>Rent This Car</p>
                        </TooltipContent>
                      </Tooltip>
                    </TooltipProvider>
                  </button>
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
                        <div className="relative w-[100%] h-[66%] -z-10">
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
        {isDialogOpen && (
          <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div className="bg-[#121212] p-8 rounded-lg w-[90%] max-w-md max-h-[90vh] overflow-y-auto">
              <h2 className="text-2xl font-semibold text-white mb-6 text-center">
                Order Form
              </h2>
              <form onSubmit={handleOrderSubmit} className="space-y-4">
                {/* User Information Section */}
                <div className="space-y-4">
                  <h3 className="text-lg font-semibold text-white">Customer Information</h3>
                  <div className="w-full p-3 rounded bg-[#2A2A2A] text-white border border-gray-600">
                    <span className="text-gray-400">Name:</span> {user.firstName} {user.lastName}
                  </div>
                  <div className="w-full p-3 rounded bg-[#2A2A2A] text-white border border-gray-600">
                    <span className="text-gray-400">Phone:</span> {user.phone}
                  </div>
                  <div className="w-full p-3 rounded bg-[#2A2A2A] text-white border border-gray-600">
                    <span className="text-gray-400">Address:</span> {user.address}
                  </div>
                </div>

                {/* Car Information Section */}
                <div className="space-y-4 mt-6">
                  <h3 className="text-lg font-semibold text-white">Car Details</h3>
                  <div className="w-full p-3 rounded bg-[#2A2A2A] text-white border border-gray-600">
                    <span className="text-gray-400">Brand/Model:</span> {currentCar.brand} {currentCar.model}
                  </div>
                  <div className="w-full p-3 rounded bg-[#2A2A2A] text-white border border-gray-600">
                    <span className="text-gray-400">Price:</span> ₱{currentCar.price.toLocaleString()}
                  </div>
                </div>

                {/* Payment Section */}
                <div className="space-y-4 mt-6">
                  <h3 className="text-lg font-semibold text-white">Payment Details</h3>
                  <select
                    name="paymentMethod"
                    value={orderFormData.paymentMethod}
                    onChange={handleInputChange}
                    className="w-full p-3 rounded bg-[#2A2A2A] text-white border border-gray-600 focus:border-accent focus:outline-none"
                  >
                    <option value="COD">Cash on Delivery</option>
                    <option value="BDO">BDO</option>
                    <option value="MetroBank">MetroBank</option>
                    <option value="PalawanPay">PalawanPay</option>
                    <option value="GCash">GCash</option>
                  </select>

                  {/* Payment Method Details */}
                  {orderFormData.paymentMethod !== 'COD' && (
                    <div className="mt-2 p-4 rounded bg-[#2A2A2A] text-white border border-gray-600">
                      <h4 className="font-semibold mb-2">{orderFormData.paymentMethod} Account Details:</h4>
                      <p>Account Name: Sports Car Dealership</p>
                      <p>Account Number: {
                        orderFormData.paymentMethod === 'BDO' ? '1234-5678-9012' :
                        orderFormData.paymentMethod === 'MetroBank' ? '9876-5432-1098' :
                        orderFormData.paymentMethod === 'PalawanPay' ? '5555-6666-7777' :
                        '8888-9999-0000' // GCash
                      }</p>
                      <p>Branch: Main Branch</p>
                    </div>
                  )}
                </div>

                {/* Terms and Conditions */}
                <div className="p-4 bg-[#2A2A2A] rounded border border-gray-600 mt-6">
                  <h4 className="font-semibold text-white mb-2">Terms and Conditions:</h4>
                  <ul className="text-sm text-gray-300 space-y-1">
                    <li>• Full payment required before delivery</li>
                    <li>• Valid ID required upon delivery</li>
                    <li>• Warranty included</li>
                    <li>• Free maintenance for 1 year</li>
                    <li>• Cancellation policy applies</li>
                  </ul>
                </div>

                {/* Action Buttons */}
                <div className="flex gap-4 justify-end mt-6">
                  <button
                    type="button"
                    onClick={() => setIsDialogOpen(false)}
                    className="px-6 py-2 rounded bg-gray-600 text-white hover:bg-gray-700 transition-colors"
                  >
                    Cancel
                  </button>
                  <button
                    type="submit"
                    className="px-6 py-2 rounded bg-accent text-white hover:bg-accent/90 transition-colors"
                  >
                    Submit Order
                  </button>
                </div>
              </form>
            </div>
          </div>
        )}
        {isRentDialogOpen && (
          <div className="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
            <div className="bg-primary p-8 rounded-lg w-full max-w-[40%] max-h-[90vh]">
              <h3 className="text-2xl font-bold text-white mb-6">
                Rent This Car
              </h3>
              <form onSubmit={handleRentSubmit} className="flex flex-col gap-4">
                <ScrollArea className="max-h-[70vh] overflow-auto">
                  <div className="space-y-4">
                    {/* Duration */}
                    <div>
                      <label className="block text-sm text-gray-400">
                        Duration
                      </label>
                      <select
                        value={rentFormData.duration}
                        onChange={(e) =>
                          setRentFormData({
                            ...rentFormData,
                            duration: e.target.value,
                          })
                        }
                        className="w-full p-3 rounded bg-[#2A2A2A] text-white border border-gray-600 focus:border-accent focus:outline-none"
                      >
                        <option value="day">Daily</option>
                        <option value="week">Weekly</option>
                        <option value="month">Monthly</option>
                      </select>
                    </div>

                    {/* Start Date */}
                    <div>
                      <label className="block text-sm text-gray-400">
                        Start Date
                      </label>
                      <input
                        type="date"
                        value={rentFormData.startDate}
                        onChange={(e) =>
                          setRentFormData({
                            ...rentFormData,
                            startDate: e.target.value,
                          })
                        }
                        min={new Date().toISOString().split("T")[0]}
                        className="w-full p-3 rounded bg-[#2A2A2A] text-white border border-gray-600 focus:border-accent focus:outline-none"
                        required
                      />
                    </div>

                    {/* Sports Car Id */}
                    <div>
                      <input
                        type="text"
                        value={currentCar.sportsCarId}
                        className="w-full p-3 rounded bg-[#2A2A2A] text-white border border-gray-600 focus:border-accent focus:outline-none"
                        hidden
                      />
                    </div>

                    {/* User Id */}
                    <div>
                      <input
                        type="text"
                        value={user.userId}
                        className="w-full p-3 rounded bg-[#2A2A2A] text-white border border-gray-600 focus:border-accent focus:outline-none"
                        hidden
                      />
                    </div>

                    {/* Full Name */}
                    <div>
                      <label className="block text-sm text-gray-400">
                        Full Name
                      </label>
                      <input
                        type="text"
                        value={user.firstName + " " + user.lastName}
                        placeholder="Enter your full name"
                        className="w-full p-3 rounded bg-[#2A2A2A] text-white border border-gray-600 focus:border-accent focus:outline-none capitalize"
                        required
                      />
                    </div>

                    {/* Phone Number */}
                    <div>
                      <label className="block text-sm text-gray-400">
                        Phone Number
                      </label>
                      <input
                        type="tel"
                        value={user.phone}
                        placeholder="Enter your phone number"
                        className="w-full p-3 rounded bg-[#2A2A2A] text-white border border-gray-600 focus:border-accent focus:outline-none"
                        required
                      />
                    </div>

                    {/* Address */}
                    <div>
                      <label className="block text-sm text-gray-400">
                        Address
                      </label>
                      <input
                        type="text"
                        value={user.address}
                        placeholder="Enter your address"
                        className="w-full p-3 rounded bg-[#2A2A2A] text-white border border-gray-600 focus:border-accent focus:outline-none capitalize"
                        required
                      />
                    </div>

                    {/* Brand/Model  */}
                    <div>
                      <label className="block text-sm text-gray-400">
                        Brand
                      </label>
                      <input
                        type="text"
                        value={`${currentCar.brand} ${currentCar.model}`}
                        placeholder="Enter your address"
                        className="w-full p-3 rounded bg-[#2A2A2A] text-white border border-gray-600 focus:border-accent focus:outline-none"
                        required
                      />
                    </div>

                    {/* Car Price */}
                    <div>
                      <label className="block text-sm text-gray-400">
                        Car Price
                      </label>
                      <input
                        type="text"
                        value={`₱${currentCar.price.toLocaleString()}`}
                        className="w-full p-3 rounded bg-[#2A2A2A] text-white border border-gray-600 focus:border-accent focus:outline-none"
                        required
                      />
                    </div>

                    {/* Rental Price and Note */}
                    <div className="p-4 bg-[#2A2A2A] rounded border border-gray-600">
                      <p className="text-white">
                        Rental Price: ₱{rentPrice.toLocaleString()}
                      </p>
                      <p className="text-sm text-yellow-500 mt-2">
                        Note: Damage charges will be 25% of the car&apos;s value
                        (₱
                        {(currentCar?.price * 0.25).toLocaleString()})
                      </p>
                    </div>

                    {/* Rental Terms */}
                    <div className="p-4 bg-[#2A2A2A] rounded border border-gray-600">
                      <h4 className="font-semibold text-white mb-2">
                        Rental Terms:
                      </h4>
                      <ul className="text-sm text-gray-300 space-y-1">
                        <li>• Full payment required before rental period</li>
                        <li>• Valid driver&apos;s license required</li>
                        <li>• Insurance coverage included</li>
                        <li>• Fuel must be replaced</li>
                        <li>• Damage charges apply for any vehicle damage</li>
                      </ul>
                    </div>
                  </div>
                </ScrollArea>

                {/* Action Buttons */}
                <div className="flex gap-4 justify-end mt-3">
                  <button
                    type="button"
                    onClick={() => setIsRentDialogOpen(false)}
                    className="px-6 py-2 rounded bg-gray-600 text-white hover:bg-gray-700 transition-colors"
                  >
                    Cancel
                  </button>
                  <button
                    type="submit"
                    className="px-6 py-2 rounded bg-accent text-white hover:bg-accent/90 transition-colors"
                  >
                    Submit Request
                  </button>
                </div>
              </form>
            </div>
          </div>
        )}
      </motion.section>
      <section className="py-12 bg-primary">
        <div className="container mx-auto">
          <div className="flex flex-col items-center mb-8">
            <h2 className="text-3xl font-bold text-white mb-4">
              Browse by Brands
            </h2>

            {/* Brand Selector */}
            <div className="w-full max-w-md">
              <select
                className="w-full p-3 rounded bg-[#2A2A2A] capitalize text-white border border-accent focus:border-accent focus:outline-none appearance-none cursor-pointer"
                onChange={(e) => setSelectedBrand(e.target.value)}
                value={selectedBrand}
              >
                <option value="">Select a Brand</option>
                {Array.from(new Set(sportsCars.map((car) => car.brand)))
                  .sort()
                  .map((brand) => (
                    <option key={brand} value={brand}>
                      {brand}
                    </option>
                  ))}
              </select>
            </div>

            {/* Display selected brand's cars */}
            <div className="w-full mt-8">
              {selectedBrand && (
                <div key={selectedBrand} className="scroll-mt-24 mb-12">
                  <h3 className="text-2xl font-semibold text-accent mb-6">
                    {selectedBrand}
                  </h3>
                  <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    {sportsCars
                      .filter((car) => car.brand === selectedBrand)
                      .map((car) => (
                        <div
                          key={car.id}
                          className="bg-secondary rounded-lg overflow-hidden hover:shadow-lg transition-shadow"
                        >
                          <div className="relative h-48">
                            <Image
                              src={`http://localhost:8000/images/${car.image}`}
                              alt={`${car.brand} ${car.model}`}
                              fill
                              className="object-cover"
                            />
                          </div>
                          <div className="p-4">
                            <h4 className="text-xl font-semibold text-white mb-2">
                              {car.model}
                            </h4>
                            <div className="flex flex-wrap gap-2 mb-3">
                              <span className="text-sm text-accent">
                                Year: {car.year}
                              </span>
                              <span className="text-sm text-accent uppercase">
                                Speed: {car.speed}
                              </span>
                            </div>
                            <div className="flex justify-between items-center">
                              <span className="text-white font-bold">
                                ₱{car.price.toLocaleString()}
                              </span>
                              <button onClick={() => setIsDialogOpen(true)}>
                                <TooltipProvider delayDuration={100}>
                                  <Tooltip>
                                    <TooltipTrigger className="w-[40px] h-[40px] rounded-full bg-white/5 flex justify-center items-center group">
                                      <BsCarFront className="text-white text-2xl group-hover:text-accent" />
                                    </TooltipTrigger>
                                    <TooltipContent>
                                      <p>Order Now</p>
                                    </TooltipContent>
                                  </Tooltip>
                                </TooltipProvider>
                              </button>
                              <button onClick={() => handleRentClick(car)}>
                                <TooltipProvider delayDuration={100}>
                                  <Tooltip>
                                    <TooltipTrigger className="w-[40px] h-[40px] rounded-full bg-white/5 flex justify-center items-center group">
                                      <BsCalendarCheck className="text-white text-2xl group-hover:text-accent" />
                                    </TooltipTrigger>
                                    <TooltipContent>
                                      <p>Rent This Car</p>
                                    </TooltipContent>
                                  </Tooltip>
                                </TooltipProvider>
                              </button>
                            </div>
                          </div>
                        </div>
                      ))}
                  </div>
                </div>
              )}
            </div>
          </div>
        </div>
      </section>
      {updateMessage && (
        <div
          className={`fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 p-4 rounded-lg shadow-lg z-50 ${
            updateMessage.type === "success"
              ? "bg-green-600 text-white"
              : "bg-red-600 text-white"
          }`}
        >
          {updateMessage.text}
        </div>
      )}
    </>
  );
};

export default SportsCars;
