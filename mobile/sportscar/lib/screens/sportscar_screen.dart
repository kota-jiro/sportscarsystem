import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../models/sportscar.dart';
import 'package:cached_network_image/cached_network_image.dart';
import '../blocs/sportscar_event.dart';
import '../blocs/sportscar_state.dart';
import '../blocs/sportscar_bloc.dart';


class SportsCarScreen extends StatelessWidget {
  const SportsCarScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xff296e48).withOpacity(0.1),
      body: SafeArea(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            _buildHeader(),
            _buildSearchBar(),
            _buildBrandFilter(),
            Expanded(
              child: _buildCarList(),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildHeader() {
    return Container(
      padding: const EdgeInsets.all(20),
      child: const Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            'Exotic Cars',
            style: TextStyle(
              fontSize: 32,
              fontWeight: FontWeight.bold,
              color: Color(0xff296e48),
            ),
          ),
          SizedBox(height: 8),
          Text(
            'Find your dream car',
            style: TextStyle(
              fontSize: 16,
              color: Colors.grey,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildSearchBar() {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 20, vertical: 10),
      padding: const EdgeInsets.symmetric(horizontal: 20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(15),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.2),
            spreadRadius: 2,
            blurRadius: 8,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      child: const TextField(
        decoration: InputDecoration(
          icon: Icon(Icons.search, color: Color(0xff296e48)),
          hintText: 'Search cars...',
          border: InputBorder.none,
        ),
      ),
    );
  }

  Widget _buildBrandFilter() {
    final brands = ['All', 'Ferrari', 'Porsche', 'Lamborghini', 'McLaren'];
    
    return Container(
      height: 50,
      margin: const EdgeInsets.symmetric(vertical: 10),
      child: ListView.builder(
        padding: const EdgeInsets.symmetric(horizontal: 15),
        scrollDirection: Axis.horizontal,
        itemCount: brands.length,
        itemBuilder: (context, index) {
          return Padding(
            padding: const EdgeInsets.symmetric(horizontal: 5),
            child: FilterChip(
              label: Text(brands[index]),
              selected: false,
              onSelected: (selected) {
                if (selected) {
                  context.read<SportsCarBloc>().add(
                    brands[index] == 'All' 
                      ? LoadSportsCars()
                      : FilterByBrand(brands[index])
                  );
                }
              },
              backgroundColor: Colors.white,
              selectedColor: const Color(0xff296e48).withOpacity(0.2),
              labelStyle: const TextStyle(color: Color(0xff296e48)),
            ),
          );
        },
      ),
    );
  }

  Widget _buildCarList() {
    return BlocBuilder<SportsCarBloc, SportsCarState>(
      builder: (context, state) {
        if (state is SportsCarLoading) {
          return const Center(
            child: CircularProgressIndicator(
              color: Color(0xff296e48),
            ),
          );
        }
        
        if (state is SportsCarError) {
          return Center(
            child: Text(
              state.message,
              style: const TextStyle(color: Colors.red),
            ),
          );
        }
        
        if (state is SportsCarLoaded) {
          return ListView.builder(
            padding: const EdgeInsets.all(16),
            itemCount: state.sportsCars.length,
            itemBuilder: (context, index) {
              return _buildCarCard(state.sportsCars[index]);
            },
          );
        }
        
        return const Center(
          child: Text('No cars available'),
        );
      },
    );
  }

  Widget _buildCarCard(SportsCar car) {
    return Card(
      margin: const EdgeInsets.only(bottom: 16),
      elevation: 4,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(15),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Stack(
            children: [
              ClipRRect(
                borderRadius: const BorderRadius.vertical(
                  top: Radius.circular(15),
                ),
                child: CachedNetworkImage(
                  imageUrl: car.carImageURL,
                  height: 200,
                  width: double.infinity,
                  fit: BoxFit.cover,
                  placeholder: (context, url) => const Center(
                    child: CircularProgressIndicator(
                      color: Color(0xff296e48),
                    ),
                  ),
                  errorWidget: (context, url, error) => const Icon(
                    Icons.error,
                    color: Colors.red,
                  ),
                ),
              ),
              Positioned(
                top: 10,
                right: 10,
                child: CircleAvatar(
                  backgroundColor: Colors.white,
                  child: IconButton(
                    icon: Icon(
                      car.isFavorated ? Icons.favorite : Icons.favorite_border,
                      color: const Color(0xff296e48),
                    ),
                    onPressed: () {
                      // Implement favorite toggle functionality
                    },
                  ),
                ),
              ),
            ],
          ),
          Padding(
            padding: const EdgeInsets.all(16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Text(
                      car.carName,
                      style: const TextStyle(
                        fontSize: 20,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                    Container(
                      padding: const EdgeInsets.symmetric(
                        horizontal: 12,
                        vertical: 6,
                      ),
                      decoration: BoxDecoration(
                        color: const Color(0xff296e48).withOpacity(0.1),
                        borderRadius: BorderRadius.circular(20),
                      ),
                      child: Text(
                        '\$${car.carPrice.toString()}',
                        style: const TextStyle(
                          color: Color(0xff296e48),
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 8),
                Text(
                  car.carType,
                  style: TextStyle(
                    color: Colors.grey[600],
                    fontSize: 16,
                  ),
                ),
                const SizedBox(height: 8),
                Text(
                  car.carDescription,
                  style: TextStyle(
                    color: Colors.grey[600],
                  ),
                ),
                const SizedBox(height: 16),
                Row(
                  children: [
                    const Icon(
                      Icons.star,
                      color: Colors.amber,
                      size: 20,
                    ),
                    const SizedBox(width: 4),
                    Text(
                      car.carRating.toString(),
                      style: const TextStyle(
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}