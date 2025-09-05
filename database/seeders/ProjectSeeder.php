<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'name' => 'Trabalho',
                'description' => 'Projetos e tarefas relacionadas ao trabalho',
                'color' => '#3B82F6',
                'icon' => '💼'
            ],
            [
                'name' => 'Pessoal',
                'description' => 'Tarefas pessoais e atividades do dia a dia',
                'color' => '#10B981',
                'icon' => '🏠'
            ],
            [
                'name' => 'Estudos',
                'description' => 'Cursos, leituras e atividades de aprendizado',
                'color' => '#8B5CF6',
                'icon' => '📚'
            ],
            [
                'name' => 'Saúde',
                'description' => 'Exercícios, consultas médicas e bem-estar',
                'color' => '#EF4444',
                'icon' => '💪'
            ]
        ];

        foreach ($projects as $project) {
            \App\Models\Project::create($project);
        }
    }
}
