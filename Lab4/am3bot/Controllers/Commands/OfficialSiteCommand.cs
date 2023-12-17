using Telegram.Bot.Types;
using Telegram.Bot;

namespace am3bot.Controllers.Commands
{
    public class OfficialSiteCommand : ICommand
    {
        public TelegramBotClient Client => Bot.GetTelegramBot().Result;

        public string Name => "Офіційний сайт🍷";

        public async Task Execute(Update update)
        {
            long chatId = update.Message.Chat.Id;


            await Client.SendTextMessageAsync(chatId, "https://amath.lp.edu.ua/");

        }
    }
}
