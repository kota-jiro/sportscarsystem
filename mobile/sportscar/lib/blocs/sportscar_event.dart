import 'package:equatable/equatable.dart';

abstract class SportsCarEvent extends Equatable {
  const SportsCarEvent();

  @override
  List<Object> get props => [];
}

class LoadSportsCars extends SportsCarEvent {
  const LoadSportsCars();

  @override
  List<Object> get props => [];
}

class FilterByBrand extends SportsCarEvent {
  final String brand;
  FilterByBrand(this.brand);

  @override
  List<Object> get props => [brand];
}

class ToggleFavorite extends SportsCarEvent {
  final int carId;
  ToggleFavorite(this.carId);

  @override
  List<Object> get props => [carId];
}
