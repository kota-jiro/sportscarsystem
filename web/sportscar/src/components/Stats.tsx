"use client";
import React, { useEffect, useState } from 'react';
import CountUp from 'react-countup';

interface StatsData {
    totalCarBrands: number;
    totalOrders: number;
    totalUsers: number;
    totalSportsCars: number;
}

const Stats = () => {
    const [stats, setStats] = useState<StatsData>({
        totalCarBrands: 0,
        totalOrders: 0,
        totalUsers: 0,
        totalSportsCars: 0
    });

    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchStats = async () => {
            try {
                const response = await fetch('http://localhost:8000/api/stats');
                const data = await response.json();
                setStats(data);
            } catch (error) {
                console.error('Error fetching stats:', error);
            } finally {
                setLoading(false);
            }
        };

        fetchStats();
    }, []);

    const statsItems = [
        {
            num: stats.totalCarBrands,
            text: "Car Brands",
        },
        {
            num: stats.totalOrders,
            text: "Orders Completed",
        },
        {
            num: stats.totalUsers,
            text: "Active Users",
        },
        {
            num: stats.totalSportsCars,
            text: "Sports Cars",
        },
    ];

    if (loading) {
        return <div className="text-center">Loading stats...</div>;
    }

    return (
        <section className='pt-4 pb-4 xl:pt-0 xl:pb-0'>
            <div className="container mx-auto pb-8">
                <div className='flex flex-wrap gap-6 max-w-[80vw] mx-auto xl:max-w-none'>
                    {statsItems.map((item, index) => {
                        return (
                            <div className='flex-1 flex gap-4 items-center justify-center xl:justify-start' key={index}>
                                <CountUp 
                                    end={item.num} 
                                    duration={5} 
                                    delay={2}
                                    className='text-4x1 xl:text-6xl font-extrabold'
                                />
                                <p className={`${item.text.length < 10 ? "max-w-[100px]" : "max-w-[150px]:"} leading-snug text-white/80`}>
                                    {item.text}
                                </p>
                            </div>
                        );
                    })}
                </div>
            </div>
        </section>
    );
};

export default Stats;