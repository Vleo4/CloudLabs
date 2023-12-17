using Telegram.Bot.Types;
using Telegram.Bot;

namespace am3bot.Controllers.Commands
{
    public class NotFoundCommand : ICommand
    {
        public TelegramBotClient Client => Bot.GetTelegramBot().Result;

        public string Name => "notfound";

        public async Task Execute(Update update)
        {
            long chatId = update.Message.Chat.Id;

            string text = "Не знаю такої команди";

            await Client.SendTextMessageAsync(
                chatId,
                text: text);
        }

    }
}
