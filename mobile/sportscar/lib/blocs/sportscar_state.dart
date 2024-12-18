import 'package:equatable/equatable.dart';
import '../models/sportscar.dart';

abstract class SportsCarState extends Equatable {
  @override
  List<Object> get props => [];
}

class SportsCarInitial extends SportsCarState {}

class SportsCarLoading extends SportsCarState {}

class SportsCarLoaded extends SportsCarState {
  final List<SportsCar> sportsCars;
  SportsCarLoaded(this.sportsCars);

  @override
  List<Object> get props => [sportsCars];
}

class SportsCarError extends SportsCarState {
  final String message;
  SportsCarError(this.message);

  @override
  List<Object> get props => [message];
}