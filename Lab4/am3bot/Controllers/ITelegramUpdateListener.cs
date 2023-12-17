using Telegram.Bot.Types;

namespace am3bot.Controllers
{
    public interface ITelegramUpdateListener
    {
        Task GetUpdate(Update update);
    }
}