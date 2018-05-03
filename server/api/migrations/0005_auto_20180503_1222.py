# Generated by Django 2.0.4 on 2018-05-03 12:22

from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    dependencies = [
        ('api', '0004_remove_damage_earthquake_id'),
    ]

    operations = [
        migrations.CreateModel(
            name='NotificationArea',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('lat', models.FloatField(blank=True, verbose_name='latitude')),
                ('lon', models.FloatField(blank=True, verbose_name='longitude')),
                ('rad', models.FloatField(blank=True, verbose_name='radius')),
                ('owner', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='api.User', verbose_name='username')),
            ],
        ),
        migrations.RemoveField(
            model_name='telegramsuperuser',
            name='owner',
        ),
        migrations.RemoveField(
            model_name='telegramuser',
            name='owner',
        ),
        migrations.DeleteModel(
            name='TelegramSuperUser',
        ),
        migrations.DeleteModel(
            name='TelegramUser',
        ),
    ]
