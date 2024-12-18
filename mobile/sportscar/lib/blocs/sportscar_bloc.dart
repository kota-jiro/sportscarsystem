import 'package:flutter_bloc/flutter_bloc.dart';
import '../repositories/sportscar_repository.dart';
import 'sportscar_event.dart';
import 'sportscar_state.dart';
import '../models/sportscar.dart';

class SportsCarBloc extends Bloc<SportsCarEvent, SportsCarState> {
  final SportsCarRepository repository;

  SportsCarBloc({required this.repository}) : super(SportsCarInitial()) {
    on<LoadSportsCars>(_onLoadSportsCars);
    on<FilterByBrand>(_onFilterByBrand);
    on<ToggleFavorite>(_onToggleFavorite);
  }

  Future<void> _onLoadSportsCars(LoadSportsCars event, Emitter<SportsCarState> emit) async {
    emit(SportsCarLoading());
    try {
      final sportsCars = await repository.getAllSportsCars();
      emit(SportsCarLoaded(sportsCars));
    } catch (e) {
      emit(SportsCarError(e.toString()));
    }
  }

  Future<void> _onFilterByBrand(FilterByBrand event, Emitter<SportsCarState> emit) async {
    emit(SportsCarLoading());
    try {
      final sportsCars = await repository.getSportsCarsByBrand(event.brand);
      emit(SportsCarLoaded(sportsCars));
    } catch (e) {
      emit(SportsCarError(e.toString()));
    }
  }

  Future<void> _onToggleFavorite(ToggleFavorite event, Emitter<SportsCarState> emit) async {
    final currentState = state;
    if (currentState is SportsCarLoaded) {
      try {
        final updatedCars = currentState.sportsCars.map((car) {
          if (car.carId == event.carId) {
            return SportsCar(
              carId: car.carId,
              carPrice: car.carPrice,
              carRating: car.carRating,
              carType: car.carType,
              carName: car.carName,
              carImageURL: car.carImageURL,
              isFavorated: !car.isFavorated,
              carDescription: car.carDescription,
            );
          }
          return car;
        }).toList();
        emit(SportsCarLoaded(updatedCars));
      } catch (e) {
        emit(SportsCarError(e.toString()));
      }
    }
  }
}