import Social from "@/components/Social";
import { Button } from "@/components/ui/button";
import { FiArrowDownCircle } from "react-icons/fi";
import React from "react";
import Photo from "@/components/Photo";
import Stats from "@/components/Stats";
import Header from "@/components/Header";

const Home = () => {
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
              <h1 className="h1 mb-6">
                {/* Hello I&apos;m <br /><span className='text-accent'>Joshua Mark</span> */}
                Find Car
                <br />
                <span className="text-accent">Ride Own</span>
              </h1>
              <p className="max-w-[500px] mb-9 text-white/80">
                Exotic Car is a platform for buying and selling high-performance
                sports cars. It provides an easy way to browse, manage, and
                explore luxury vehicles with detailed information and images,
                ensuring a smooth and reliable experience for all users.
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
